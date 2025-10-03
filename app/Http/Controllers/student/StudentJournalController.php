<?php

namespace App\Http\Controllers\student;

use App\Models\Journal;
use App\Models\Notification;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use App\Models\JournalAttachment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentJournalController extends Controller
{
    public function index(Request $request)
{
    $student = Auth::guard('student')->user();

    $journals = Journal::with('attachments')
        ->where('student_id', $student->id)
        ->when($request->start_date, function ($query) use ($request) {
            $query->whereDate('journal_date', '>=', $request->start_date);
        })
        ->when($request->end_date, function ($query) use ($request) {
            $query->whereDate('journal_date', '<=', $request->end_date);
        })
        ->orderBy('journal_date', 'desc')
        ->paginate(2)->withQueryString();

    return view('student.journals.index', compact('journals', 'student'));
}


    public function create(){
        $student = Auth::guard('student')->user();
        return view('student.journals.create', compact('student'));
    }

public function store(Request $request)
    {
        $student = Auth::guard('student')->user();
        $company = $student->company;

        // 1. Validate inputs
        $validated = $request->validate([
            'journal_date' => 'required|date|before_or_equal:today',
            'content' => ['required', 'string', function($attribute, $value, $fail) {
                if (str_word_count($value) < 300) {
                    $fail('The journal content must be at least 300 words.');
                }
            }],
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:2048',
        ], [
            'journal_date.before_or_equal' => 'You cannot submit a journal entry for a future date.',
        ]);

        // 2. Check if company exists and has start date
        if (!$company || !$company->default_start_date) {
            return back()->with('error', 'Journal submission is not yet allowed. Please wait until the company sets the start date.');
        }

        $timezone = 'Asia/Manila';
        $now = \Carbon\Carbon::now($timezone);
        $journalDate = \Carbon\Carbon::parse($validated['journal_date'], $timezone)->startOfDay();
        $startDate = \Carbon\Carbon::parse($company->default_start_date, $timezone)->startOfDay();

        // 3. Prevent submission before company start date
        if ($journalDate->lt($startDate)) {
            return back()->with('error', 'Journal submission is not allowed before the company start date.');
        }

        // 4. Check for today’s submission restriction
        if ($journalDate->eq($now->copy()->startOfDay())) {

            // Fetch override if exists
            $override = \App\Models\CompanyTimeOverride::where('company_id', $company->id)
                ->whereDate('date', $journalDate)
                ->first();

            // Determine effective Time Out
            if ($override && $override->time_out_end) {
                $timeOut = $journalDate->copy()->setTimeFromTimeString($override->time_out_end);
            } elseif ($company->allowed_time_out_end) {
                $timeOut = $journalDate->copy()->setTimeFromTimeString($company->allowed_time_out_end);
            } else {
                return back()->with('error', 'Company has not set Time Out yet.');
            }

            $allowTime = $timeOut->copy()->subMinutes(30);

            if ($now->lt($allowTime)) {
                return back()->with('error', 'You cannot submit today’s journal yet. Allowed from ' . $allowTime->format('g:i A'));
            }
        }

        // 5. Create journal
        $journal = Journal::create([
            'student_id' => $student->id,
            'journal_date' => $validated['journal_date'],
            'content' => $validated['content'],
        ]);

        // 6. Handle attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('journals', 'public');
                JournalAttachment::create([
                    'journal_id' => $journal->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                ]);
            }
        }

        // 7. Notify faculty
        if ($student->faculty_id) {
            Notification::create([
                'user_id' => $student->faculty_id,
                'user_type' => 'faculty',
                'title' => 'New Journal Submission',
                'message' => $student->name . ' submitted a new journal entry.',
                'type' => 'journal',
                'source_type' => 'company_feedback',
                'is_read' => 0,
            ]);
        }

        return redirect()->route('student.journals.create')->with('success', 'Journal submitted successfully.');
    }







public function downloadWord($id)
{
    $journal = Journal::with(['attachments', 'student.company'])->findOrFail($id);

    $phpWord = new PhpWord();

    // Create section with header/footer
    $section = $phpWord->addSection();

    // --- HEADER ---
    $header = $section->addHeader();
    $header->addText(
        'TCM OJT Monitoring System',
        ['bold' => true, 'size' => 12],
        ['align' => 'center']
    );

    // --- FOOTER ---
    $footer = $section->addFooter();
    $footer->addPreserveText(
        'Page {PAGE} of {NUMPAGES}',
        ['italic' => true, 'size' => 10],
        ['align' => 'center']
    );

    // --- TITLE ---
    $section->addText("OJT Journal Entry", ['bold' => true, 'size' => 18], ['align' => 'center']);
    $section->addTextBreak(1);

    // --- Student Info ---
    $section->addText("Name: " . $journal->student->name, ['bold' => true, 'size' => 12]);
    $section->addText("Company: " . ($journal->student->company->name ?? 'Not Assigned'), ['bold' => true, 'size' => 12]);
    $section->addText("Date: " . \Carbon\Carbon::parse($journal->journal_date)->format('F d, Y'), ['bold' => true, 'size' => 12]);
    $section->addTextBreak(1);

    // --- Journal Content (JUSTIFIED) ---
    $section->addText("Journal Content", ['bold' => true, 'size' => 14]);
    $section->addText(
        $journal->content,
        ['size' => 12],
        ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH] // <-- Justify
    );
    $section->addTextBreak(1);

    // --- Attachments ---
    if ($journal->attachments->count()) {
        $section->addText("Attachments:", ['bold' => true, 'size' => 12]);
        foreach ($journal->attachments as $file) {
            $section->addText("• " . basename($file->file_path), ['size' => 11, 'color' => '555555']);
        }
    }

    // --- Save & Download ---
    $fileName = 'journal_' . $journal->student->name . '_' . $journal->journal_date . '.docx';
    $tempFile = tempnam(sys_get_temp_dir(), 'word');
    $writer = IOFactory::createWriter($phpWord, 'Word2007');
    $writer->save($tempFile);

    return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
}





}

