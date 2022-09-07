<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File as FileHelp;

class FormController extends Controller
{
    public function createForm($id)
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
            return view('teacher.form.create-form', compact('subject'));
        }
    }

    public function postCreateForm(Request $request)
    {
        $request->validate([
            "subject_id" => "required",
            "name" => "required",
        ]);

        $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
        $sub_ids = [];
        foreach ($cur_user->subject as $s) {
            $sub_ids[] = $s->id;
        }
        if (!in_array($request->subject_id, $sub_ids)) {
            return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
        } else {
            $form = Form::create([
                "name" => $request->name,
                "subject_id" => $request->subject_id,
            ]);

            if ($form) {
                return redirect("/teacher-student/your-subjects/view/" . $request->subject_id)->with("success", "New form created!");
            } else {
                return redirect("/teacher-student/your-subjects/view/" . $request->subject_id)->with("error", "Something went wrong!");
            }
        }
    }

    public function viewForm($id)
    {
        $form = Form::where("id", $id)->with("subject", "upload")->first();

        if ($form) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $sub_ids = [];
            foreach ($cur_user->subject as $s) {
                $sub_ids[] = $s->id;
            }

            if (!in_array($form->subject_id, $sub_ids)) {
                return redirect()->back()->with("error", "Unauthorized access!");
            } else {
                $form_id = $form->id;

                $students = User::with(["upload" => function ($query) use ($form_id) {
                    $query->where("form_id", $form_id);
                }])->whereHas('upload', function ($query) use ($form_id) {
                    $query->where('form_id', $form_id);
                })->orderBy("name")->get();

                return view('teacher.form.view-form', compact('students', 'form'));
            }
        } else {
            return redirect()->back()->with("error", "Unable to find form!");
        }
    }

    public function deleteForm(Request $request)
    {
        $request->validate([
            "form_id" => "required",
        ]);

        $form = Form::where("id", $request->form_id)->with("upload", "subject")->first();

        if ($form) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $sub_ids = [];
            foreach ($cur_user->subject as $s) {
                $sub_ids[] = $s->id;
            }

            if (!in_array($form->subject_id, $sub_ids)) {
                return redirect()->back()->with("error", "Unauthorized access!");
            } else {
                foreach ($form->upload as $u) {
                    if (FileHelp::exists(public_path("/storage/uploads/" . $u->file_path))) {
                        FileHelp::delete(public_path("/storage/uploads/" . $u->file_path));
                    }
                    $u->delete();
                }
                $sub_id = $form->subject->id;
                $form->delete();
                return redirect("/teacher-student/your-subjects/view/" . $sub_id)->with("info", "Form has been deleted!");
            }
        } else {
            return redirect()->back()->with("error", "Unable to find form!");
        }
    }

    public function editForm($id)
    {

        $form = Form::where("id", $id)->with("subject")->first();

        if ($form) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $sub_ids = [];
            foreach ($cur_user->subject as $s) {
                $sub_ids[] = $s->id;
            }

            if (!in_array($form->subject_id, $sub_ids)) {
                return redirect()->back()->with("error", "Unauthorized access!");
            } else {
                return view('teacher.form.update-form', compact('form'));
            }
        } else {
            return redirect()->back()->with("error", "Unable to find form!");
        }
    }

    public function postEditForm(Request $request)
    {
        $request->validate([
            "form_id" => "required",
            "name" => "required",
        ]);

        $form = Form::where("id", $request->form_id)->with("subject")->first();

        if ($form) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $sub_ids = [];
            foreach ($cur_user->subject as $s) {
                $sub_ids[] = $s->id;
            }

            if (!in_array($form->subject_id, $sub_ids)) {
                return redirect()->back()->with("error", "Unauthorized access!");
            } else {
                $form->name = $request->name;
                $form->save();
                return redirect()->back()->with("success", "Form name updated!");
            }
        } else {
            return redirect()->back()->with("error", "Unable to find form!");
        }
    }
}
