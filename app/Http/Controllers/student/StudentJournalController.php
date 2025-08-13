<?php

namespace App\Http\Controllers\student;

use App\Models\Journal;
use App\Models\Notification;
use Illuminate\Http\Request;
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
        ->paginate(3)->withQueryString();

    return view('student.journals.index', compact('journals', 'student'));
}

    //
    public function create(){
        $student = Auth::guard('student')->user();
        return view('student.journals.create', compact('student'));
    }

    public function store(Request $request){

        $student = Auth::guard('student')->user();
        $validated = $request->validate([
            'journal_date' => 'required|date',
            'content' => 'required|string',
            'attachments.*' => 'nullable|file|mimes: pdf,doc,docx,jpg,jpeg,png,gif,bmp|max:2048',
        ]);

        //
        $journal = Journal::create([
            'student_id' => Auth::guard('student')->id(),
            'journal_date' => $validated['journal_date'],
            'content' => $validated['content'],
        ]);

        //for multiple attachments
        if($request->hasFile('attachments')){
            foreach($request->file('attachments') as $file){
                $path = $file->store('journals', 'public');

                JournalAttachment::create([
                    'journal_id' => $journal->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension()
                ]);
            }
        }

        // Create notification for  faculty
        if ($student->faculty_id) {
        Notification::create([
            'user_id' => $student->faculty_id, // faculty's ID
            'user_type' => 'faculty',
            'title' => 'New Journal Submission',
            'message' => $student->name . ' submitted a new journal entry.',
            'type' => 'journal',
            'source_type' => 'company_feedback',
            'is_read' => 0,
        ]);
    }



        return redirect()->route('student.journals.create')->with('success', 'Journal created successfully');
    }
}
