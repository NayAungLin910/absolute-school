<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Form;
use App\Models\Moderator;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileHelp;

class SearchController extends Controller
{
    // search student
    public function searchStudent()
    {
        $students = User::where('approve', 'yes')->orderBy('id', 'DESC')->with('batch')->paginate(10);
        $batches = Batch::orderBy('name')->get();
        $startdate = "";
        $enddate = "";
        $search = "";
        $chose_batch_id = "";
        $unassigned = false;
        return view('search.search-student', compact('students', 'batches', 'startdate', 'enddate', 'search', 'chose_batch_id', 'unassigned'));
    }

    public function postSearchStudent(Request $request)
    {
        $students = User::where('approve', 'yes')->with('batch');
        $batches = Batch::orderBy('name')->get();
        $request->validate([
            "search" => "required"
        ]);

        $search = "";

        if ($request->search) {
            $search = $request->search;
            $students = $students->where("email", "like", "%$request->search%");
        }

        $chose_batch_id = "";

        if ($request->batch) {
            $chose_batch_id = $request->batch;
            $students->whereHas("batch", function ($q) use ($chose_batch_id) {
                $q->where('batch_id', $chose_batch_id);
            });
        }

        $startdate = "";
        $enddate = "";


        if ($request->startdate && $request->enddate) {
            $students = $students->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $unassigned = false;

        if ($request->unassigned) {
            $unassigned = true;
            $students = $students->whereDoesntHave('batch');
        }

        $students = $students->orderBy('id', 'DESC')->paginate(10);
        return view('search.search-student', compact('students', 'batches', 'startdate', 'enddate', 'search', 'chose_batch_id', 'unassigned'));
    }

    public function assignBatch($id)
    {
        $student = User::where('id', $id)->with('batch')->first();
        $batches = Batch::orderBy('id', 'DESC')->get();
        return view('search.search-student-assign-batch', compact('student', 'batches'));
    }

    public function postAssignBatch(Request $request, $id)
    {
        $request->validate([
            "batch" => "required",
        ]);
        $student = User::where('id', $id)->first();
        if ($student) {
            $batch_arr = [$request->batch];
            $student->batch()->detach();
            $student->batch()->sync($batch_arr);
            return redirect()->back()->with("success", $student->name . " batch information updated!");
        } else {
            return redirect()->back()->with("error", "Student not found!");
        }
    }

    public function postDeleteStudent(Request $request)
    {
        $student = User::where('id', $request->id)->with("upload")->first();

        if ($student) {

            $uploads = Upload::where("user_id", $student->id)->get();
            if ($uploads) {
                foreach ($uploads as $u) {
                    if (FileHelp::exists(public_path("/storage/uploads/" . $u->file_path))) {
                        FileHelp::delete(public_path("/storage/uploads/" . $u->file_path));
                    }
                    $u->delete();
                }
            }

            $s_email = $student->email;
            if (FileHelp::exists(public_path("/storage/images/" . $student->image))) {
                FileHelp::delete(public_path("/storage/images/" . $student->image));
            }
            $student->batch()->detach();
            $student->delete();
            return redirect()->back()->with("info", $s_email . " account has been deleted!");
        } else {
            return redirect()->back()->with("error", "Student not found!");
        }
    }
    // search teacher
    public function searchTeacher()
    {
        $teachers = Teacher::where('approve', 'yes')->orderBy('id', 'DESC')->paginate(10);
        $startdate = "";
        $enddate = "";
        $search = "";
        return view('search.search-teacher', compact('teachers', 'startdate', 'enddate', 'search'));
    }

    public function postSearchTeacher(Request $request)
    {
        $teachers = Teacher::where('approve', 'yes');
        $request->validate([
            "search" => "required"
        ]);

        $search = "";

        if ($request->search) {
            $search = $request->search;
            $teachers = $teachers->where("email", "like", "%$request->search%");
        }

        $startdate = "";
        $enddate = "";


        if ($request->startdate && $request->enddate) {
            $teachers = $teachers->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $teachers = $teachers->orderBy('id', 'DESC')->paginate(10);
        return view('search.search-teacher', compact('teachers', 'startdate', 'enddate', 'search'));
    }

    public function postDeleteTeacher(Request $request)
    {
        $teacher = Teacher::where('id', $request->id)->with("subject")->first();
        if ($teacher) {
            foreach ($teacher->subject as $s) {
                $subject = Subject::where("id", $s->id)->with("section", "form")->first();
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
                $s->delete();
            }

            $t_email = $teacher->email;
            if (FileHelp::exists(public_path("/storage/images/" . $teacher->image))) {
                FileHelp::delete(public_path("/storage/images/" . $teacher->image));
            }
            $teacher->delete();
            return redirect()->back()->with("info", $t_email . " account has been deleted!");
        } else {
            return redirect()->back()->with("error", "Teacher not found!");
        }
    }
    // search moderator
    public function searchModerator()
    {
        $moderators = Moderator::where('approve', 'yes')->orderBy('id', 'DESC')->paginate(10);
        $startdate = "";
        $enddate = "";
        $search = "";
        return view('search.search-moderator', compact('moderators', 'startdate', 'enddate', 'search'));
    }

    public function postSearchModerator(Request $request)
    {
        $moderators = Moderator::where('approve', 'yes');
        $request->validate([
            "search" => "required"
        ]);

        $search = "";

        if ($request->search) {
            $search = $request->search;
            $moderators = $moderators->where("email", "like", "%$request->search%");
        }

        $startdate = "";
        $enddate = "";


        if ($request->startdate && $request->enddate) {
            $moderators = $moderators->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $moderators = $moderators->orderBy('id', 'DESC')->paginate(10);
        return view('search.search-moderator', compact('moderators', 'startdate', 'enddate', 'search'));
    }

    public function postDeleteModerator(Request $request)
    {
        $moderator = Moderator::where('id', $request->id)->first();
        if ($moderator) {
            $m_email = $moderator->email;
            $moderator->delete();
            return redirect()->back()->with("info", $m_email . " account has been deleted!");
        } else {
            return redirect()->back()->with("error", "Moderator not found!");
        }
    }
}
