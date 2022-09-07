<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function editZoomInfo($id)
    {
        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        if (!in_array($id, $sub_ids)) {
            return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
        } else {
            $subject = Subject::where('id', $id)->with('moderator', 'admin', 'teacher', 'batch')->first();
            $teachers = Teacher::latest()->where("approve", "yes")->get();
            $batches = Batch::latest()->get();
            return view('teacher.subject.update-subject', compact('subject', 'teachers', 'batches'));
        }
    }
    public function postEditZoomInfo(Request $request)
    {
        $request->validate([
            "subject_id" => "required",
            "meeting_id" => "required",
            "meeting_password" => "required",
            "meeting_link" => "required",
        ]);

        $subject = Subject::where('id', $request->subject_id)->first();
        if ($subject) {
            Subject::where('id', $subject->id)->update([
                "meeting_id" => $request->meeting_id,
                "meeting_password" => $request->meeting_password,
                "meeting_link" => $request->meeting_link,
            ]);
            return redirect()->back()->with("success", "Zoom meeting information updated!");
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Subject not found!");
        }
    }
}
