<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalManagementController extends Controller
{
    //

    public function index(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();

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

    return view('faculty.journals.index', compact('journals', 'faculty'));
    }
}
