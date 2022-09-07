<?php

namespace App\Http\Controllers\TeacherStudent;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function yourSubjects()
    {
        if (Auth::check()) {
            $cur_user = User::where('id', Auth::user()->id)->with('batch.subject')->first();
            $subjects = [];
            if (count($cur_user->batch) > 0) {
                $batch_id =  $cur_user->batch[0]->id;
                $subjects = Subject::orderBy('id', 'DESC')->where('batch_id', $batch_id)->paginate(10);
            }
        } elseif (Auth::guard('teacher')->check()) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $subjects = Subject::orderBy('id', 'DESC')->where('teacher_id', $cur_user->id)->paginate(10);
        }

        $startdate = "";
        $enddate = "";
        $search = "";

        return view('teacher-student.index-subject', compact('subjects', 'startdate', 'enddate', 'search'));
    }

    public function postYourSubjects(Request $request)
    {
        if (Auth::check()) {
            $cur_user = User::where('id', Auth::user()->id)->with('batch.subject')->first();
            $subjects = [];
            if (count($cur_user->batch) > 0) {
                $batch_id =  $cur_user->batch[0]->id;
                $subjects = Subject::orderBy('id', 'DESC')->where('batch_id', $batch_id);

                $search = "";
                if ($request->search) {
                    $search = $request->search;
                    $subjects = $subjects->where("name", "like", "%$request->search%");
                }

                $startdate = "";
                $enddate = "";
                if ($request->startdate && $request->enddate) {
                    $subjects = $subjects->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
                    $startdate = $request->startdate;
                    $enddate = $request->enddate;
                }

                $subjects = $subjects->paginate(10);
            }
        } elseif (Auth::guard('teacher')->check()) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            $subjects = Subject::orderBy('id', 'DESC')->where('teacher_id', $cur_user->id);

            $search = "";
            if ($request->search) {
                $search = $request->search;
                $subjects = $subjects->where("name", "like", "%$request->search%");
            }

            $startdate = "";
            $enddate = "";
            if ($request->startdate && $request->enddate) {
                $subjects = $subjects->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
                $startdate = $request->startdate;
                $enddate = $request->enddate;
            }

            $subjects = $subjects->paginate(10);
        }

        return view('teacher-student.index-subject', compact('subjects', 'startdate', 'enddate', 'search'));
    }

    public function viewSubject($id)
    {
        $cur_user = "";
        $sub_ids = [];
        if (Auth::check()) {
            $cur_user = User::where('id', Auth::user()->id)->with('batch.subject')->first();
            if (count($cur_user->batch) > 0) {
                foreach ($cur_user->batch[0]->subject as $s) {
                    $sub_ids[] = $s->id;
                }
            } else {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            }
        } elseif (Auth::guard('teacher')->check()) {
            $cur_user = Teacher::where('id', Auth::guard('teacher')->user()->id)->with('subject')->first();
            foreach ($cur_user->subject as $s) {
                $sub_ids[] = $s->id;
            }
        }
        if (!in_array($id, $sub_ids)) {
            return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
        } else {
            $subject = Subject::where('id', $id)->with('teacher', 'admin', 'moderator', 'batch', 'form.upload', 'section.file')->first();
            if (Auth::check()) {
                $forms = Form::where("subject_id", $subject->id)->with(['upload' => function ($query) {
                    $query->where("user_id", Auth::user()->id);
                }])->get();
            } elseif (Auth::guard('teacher')->check()) {
                $forms = Form::where("subject_id", $subject->id)->with("upload.user")->get();
                $batch_id = $subject->batch->id;
            }

            return view('teacher-student.subject', compact('subject', 'forms'));
        }
    }
}
