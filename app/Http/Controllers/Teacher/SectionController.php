<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FileHelp;

class SectionController extends Controller
{
    public function createSection($id)
    {
        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        if (!in_array($id, $sub_ids)) {
            return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
        } else {
            $subject = Subject::where('id', $id)->first();
            return view('teacher.section.create-section', compact('subject'));
        }
    }

    public function postCreateSection(Request $request)
    {
        $request->validate([
            "name" => "required",
            "subject_id" => "required",
        ]);

        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        if (!in_array($request->subject_id, $sub_ids)) {
            return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
        } else {
            $section = Section::create([
                "name" => $request->name,
                "subject_id" => $request->subject_id,
            ]);

            if ($section) {
                return redirect('/teacher-student/your-subjects/view/' . $request->subject_id)->with("success", $section->name . " has been created!");
            } else {
                return redirect("/teacher/create-section/" . $request->subject_id)->with("error", "Failed to create section!");
            }
        }
    }

    public function addFile($id)
    {
        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        $section = Section::where('id', $id)->with('subject')->first();
        if ($section) {
            if (!in_array($section->subject->id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                return view('teacher.section.file.create-file', compact('section'));
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Section not found!");
        }
    }

    public function postAddFile(Request $request)
    {
        $request->validate([
            "section_id" => "required",
            "file" => "required|max:10240",
        ]);

        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        $section = Section::where('id', $request->section_id)->with('subject')->first();
        if ($section) {
            if (!in_array($section->subject->id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                $file = $request->file('file');
                $d_name = $file->getClientOriginalName();
                $file_name = uniqid() . $file->getClientOriginalName();
                $file_path = "/storage/files/" . $file_name;
                $file->move(public_path("/storage/files"), $file_name);

                $file_uploaded = File::create([
                    "name" => $d_name,
                    "file_path" => $file_name,
                    "section_id" => $request->section_id,
                ]);

                if ($file_uploaded) {
                    return redirect('/teacher-student/your-subjects/view/' . $section->subject->id)->with("success", "File has been uploaded!");
                } else {
                    return redirect('/teacher-student/your-subjects/view/' . $section->subject->id)->with("error", "File upload failed!");
                }
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Section not found!");
        }
    }

    public function postDeleteFile(Request $request)
    {
        $request->validate([
            "file_id" => "required",
        ]);

        $file = File::where('id', $request->file_id)->first();

        if ($file) {
            if (FileHelp::exists(public_path("/storage/files/" . $file->file_path))) {
                FileHelp::delete(public_path("/storage/files/" . $file->file_path));
            }
            $file->delete();
            return redirect()->back()->with("info", "File has been deleted!");
        } else {
            return redirect()->back()->with("error", "File not found!");
        }
    }

    public function editSection($id)
    {
        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        $section = Section::where('id', $id)->with('subject')->first();
        if ($section) {
            if (!in_array($section->subject->id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                return view('teacher.section.update-section', compact('section'));
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Section not found!");
        }
    }

    public function postEditSection(Request $request)
    {
        $request->validate([
            "section_id" =>  "required",
            "name" => "required",
        ]);

        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        $section = Section::where('id', $request->section_id)->with('subject')->first();
        if ($section) {
            if (!in_array($section->subject->id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                $section->name = $request->name;
                $section->save();
                return redirect()->back()->with("success", "New section name has been saved!");
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Section not found!");
        }
    }

    public function postDeleteSection(Request $request)
    {
        $request->validate([
            "section_id" =>  "required",
        ]);

        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        $section = Section::where('id', $request->section_id)->with('subject', 'file')->first();
        if ($section) {
            if (!in_array($section->subject->id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                foreach ($section->file as $f) {
                    if (FileHelp::exists(public_path("/storage/files/" . $f->file_path))) {
                        FileHelp::delete(public_path("/storage/files/" . $f->file_path));
                    }
                    $f->delete();
                }
                $section->delete();
                return redirect()->back()->with("info", "Section has been deleted!");
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Section not found!");
        }
    }
}
