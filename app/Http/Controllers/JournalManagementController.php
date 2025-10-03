<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalManagementController extends Controller
{
    //

    public function index(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();

        // Fetch journals of students under this faculty
        $journals = Journal::with(['student.course', 'student.company', 'attachments'])
            ->whereHas('student', function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('student', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->date, function ($query) use ($request) {
                $query->whereDate('journal_date', $request->date);
            })
            ->orderByDesc('journal_date')
            ->paginate(7);

        // Calculate status for each journal
        foreach ($journals as $journal) {
            $student = $journal->student;
            $company = $student->company;

            if (!$company) {
                $journal->status = 'On Time'; // fallback if no company assigned
                continue;
            }

            // Get schedule for the journal date
            $schedule = $company->attendanceWindowForDate($journal->journal_date);

            // Build deadline datetime (journal date + allowed end time)
            $deadline = Carbon::parse($journal->journal_date . ' ' . $schedule['time_in_end'])
                            ->timezone(config('app.timezone'));

            // Submitted timestamp
            $submittedAt = Carbon::parse($journal->created_at)
                                ->timezone(config('app.timezone'));

            // Compare
            $journal->status = $submittedAt->gt($deadline) ? 'Late' : 'On Time';
        }

        return view('faculty.journals.index', compact('journals', 'faculty'));
    }


public function deductPenalty(Request $request, Journal $journal)
{
    $request->validate([
        'penalty_hours' => 'required|numeric|min:0.1',
    ]);

    $attendance = $journal->student->attendances()
        ->whereDate('date', $journal->journal_date)
        ->first();

    if (!$attendance) {
        return back()->with('error', 'No attendance record found for this student on this date.');
    }

    // Prevent multiple deductions
    if ($attendance->penalty_hours > 0) {
        return back()->with('error', 'Penalty has already been applied for this journal.');
    }

    $attendance->penalty_hours = $request->penalty_hours;
    $attendance->save();

    // Notify student
    \App\Models\Notification::create([
        'user_id'   => $journal->student->id,
        'user_type' => 'student',
        'type'      => 'penalty',
        'title'     => 'Penalty Applied',
        'message'   => 'A penalty of ' . $request->penalty_hours . ' hour(s) was applied to your journal submitted on ' . $journal->journal_date,
        'is_read'   => false,
    ]);

    return back()->with('success', 'Penalty applied and student notified successfully.');
}






}
