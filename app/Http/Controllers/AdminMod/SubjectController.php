<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Form;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FileHelp;

class SubjectController extends Controller
{
    public function subject(Request $request)
    {
        $subjects = Subject::orderBy('id', 'DESC');
        $search = "";
        $startdate = "";
        $enddate = "";

        if ($request->search) {
            $subjects = $subjects->where("name", "like", "%$request->search%");
            $search = $request->search;
        }

        if ($request->startdate && $request->enddate) {
            $subjects =  $subjects->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $subjects = $subjects->with('moderator', 'admin', 'teacher', 'batch')->paginate(10);
        return view('admin-mod.subject.index-subject', compact('subjects', 'startdate', 'enddate', 'search'));
    }

    public function createSubject()
    {
        $teachers = Teacher::latest()->where("approve", "yes")->get();
        $batches = Batch::latest()->get();

        return view('admin-mod.subject.create-subject', compact('teachers', 'batches'));
    }

    public function postCreateSubject(Request $request)
    {
        $request->validate([
            "name" => "required|unique:subjects,name",
            "teacher" => "required",
            "batch" => "required",
            "meeting_id" => "required",
            "meeting_password" => "required",
            "meeting_link" => "required",
        ]);

        if (Auth::guard('admin')->check()) {
            $subject = Subject::create([
                "name" => $request->name,
                "teacher_id" => $request->teacher,
                "batch_id" => $request->batch,
                "admin_id" => Auth::guard('admin')->user()->id,
                "meeting_id" => $request->meeting_id,
                "meeting_password" => $request->meeting_password,
                "meeting_link" => $request->meeting_link,
            ]);
        } else if (Auth::guard('moderator')->check()) {
            $subject = Subject::create([
                "name" => $request->name,
                "teacher_id" => $request->teacher,
                "batch_id" => $request->batch,
                "moderator_id" => Auth::guard('moderator')->user()->id,
                "meeting_id" => $request->meeting_id,
                "meeting_password" => $request->meeting_password,
                "meeting_link" => $request->meeting_link,
            ]);
        }

        if ($subject) {
            return redirect()->back()->with("success", $subject->name . " has been created!");
        } else {
            return redirect()->back()->with("error", "Something went wrong!");
        }
    }

    public function deleteSubject(Request $request)
    {
        $subject = Subject::where('id', $request->id)->with("form", "section")->first();
        $s_name = $subject->name;
        
        if ($subject) {
            foreach ($subject->section as $sec) {
                $section = Section::where("id", $sec->id)->with("file")->first();
                foreach ($section->file as $f) {
                    if (FileHelp::exists(public_path("/storage/files/" . $f->file_path))) {
                        FileHelp::delete(public_path("/storage/files/" . $f->file_path));
                    }
                    $f->delete();
                }
                $section->delete();
            }

            foreach ($subject->form as $f) {
                $form = Form::where("id", $f->id)->with("upload")->first();
                foreach ($form->upload as $u) {
                    if (FileHelp::exists(public_path("/storage/uploads/" . $u->file_path))) {
                        FileHelp::delete(public_path("/storage/uploads/" . $u->file_path));
                    }
                    $u->delete();
                }
                $form->delete();
            }
            $subject->delete();
            return redirect('/admin-mod/subject')->with("success", $s_name . " has been deleted!");
        } else {
            return redirect()->back()->with("error", "Unable to find subject!");
        }
    }

    public function editSubject($id)
    {
        $subject = Subject::where('id', $id)->with('moderator', 'admin', 'teacher', 'batch')->first();
        $teachers = Teacher::latest()->where("approve", "yes")->get();
        $batches = Batch::latest()->get();
        return view('admin-mod.subject.update-subject', compact('subject', 'teachers', 'batches'));
    }

    public function postEditSubject(Request $request)
    {
        $request->validate([
            "subject_id" => "required",
            "name" => "required|unique:subjects,name," . $request->subject_id,
            "teacher" => "required",
            "batch" => "required",
            "meeting_id" => "required",
            "meeting_password" => "required",
            "meeting_link" => "required",
        ]);

        $subject = Subject::where('id', $request->subject_id)->first();

        if ($subject) { 
            Subject::where('id', $subject->id)->update([
                "name" => $request->name,
                "teacher_id" => $request->teacher,
                "batch_id" => $request->batch,
                "meeting_id" => $request->meeting_id,
                "meeting_password" => $request->meeting_password,
                "meeting_link" => $request->meeting_link,
            ]);
            return redirect()->back()->with("success", "A new subject information has been saved!");
        } else {
            return redirect()->back()->with("error", "Subject not found!");
        }
    }
}
