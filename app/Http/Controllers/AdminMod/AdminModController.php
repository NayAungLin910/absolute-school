<?php

namespace App\Http\Controllers\AdminMod;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Moderator;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FileHelp;

class AdminModController extends Controller
{
    # statistics for admin and moderators
    public function statistics()
    {
        $student_count = User::all()->count();
        $teacher_count = Teacher::all()->count();
        $moderator_count = Moderator::all()->count();
        $admin_count = Admin::all()->count();
        return view('admin-mod.statistics', compact('student_count', 'teacher_count', 'moderator_count', 'admin_count'));
    }

    #Approve moderator------

    public function approveModerator(Request $request)
    {
        $moderators = Moderator::where('approve', 'no');

        $startdate = "";
        $enddate = "";
        $search = "";

        if ($request->search) {
            $moderators = $moderators->where("email", "like", "%$request->search%");
            $search = $request->search;
        }

        if ($request->startdate && $request->enddate) {
            $moderators = $moderators->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $moderators = $moderators->orderBy('id', 'DESC')->paginate('10');

        return view('admin-mod.approve-moderator', compact('moderators', 'startdate', 'enddate', 'search'));
    }

    public function postApproveModerator(Request $request)
    {
        $mod_id = $request->id;
        $moderator = Moderator::where('id', $mod_id)->first();
        if ($moderator) {
            $moderator->approve = "yes";
            $moderator->save();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Moderator was not found!");
        }
    }

    public function postDeclineModerator(Request $request)
    {
        $mod_id = $request->id;
        $moderator = Moderator::where('id', $mod_id)->first();
        if ($moderator) {
            $moderator->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Moderator was not found!");
        }
    }

    #Approve teacher------

    public function approveTeacher(Request $request)
    {
        $teachers = Teacher::where('approve', 'no');

        $startdate = "";
        $enddate = "";
        $search = "";

        if ($request->search) {
            $teachers = $teachers->where("email", "like", "%$request->search%");
            $search = $request->search;
        }

        if ($request->startdate && $request->enddate) {
            $teachers = $teachers->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $teachers = $teachers->orderBy("id", "DESC")->paginate(10);

        return view('admin-mod.approve-teacher', compact('teachers', 'startdate', 'enddate', 'search'));
    }

    public function postApproveTeacher(Request $request)
    {
        $t_id = $request->id;
        $teacher = Teacher::where('id', $t_id)->first();
        if ($teacher) {
            $teacher->approve = "yes";
            $teacher->save();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Teacher was not found!");
        }
    }

    public function postDeclineTeacher(Request $request)
    {
        $t_id = $request->id;
        $teacher = Teacher::where('id', $t_id)->first();
        if ($teacher) {
            if (FileHelp::exists(public_path("/storage/images/" . $teacher->image))) {
                FileHelp::delete(public_path("/storage/images/" . $teacher->image));
            }
            $teacher->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Teacher was not found!");
        }
    }

    #Approve student------

    public function approveStudent(Request $request)
    {
        $students = User::where('approve', 'no');
        $startdate = "";
        $enddate = "";
        $search = "";

        if ($request->search) {
            $students = $students->where("email", "like", "%$request->search%");
            $search = $request->search;
        }

        if ($request->startdate && $request->enddate) {
            $students = $students->whereBetween('created_at', [$request->startdate . " 00:00:00", $request->enddate . " 23:59:59"]);
            $startdate = $request->startdate;
            $enddate = $request->enddate;
        }

        $students = $students->orderBy('id', 'DESC')->paginate(10);

        return view('admin-mod.approve-student', compact('students', 'startdate', 'enddate', 'search'));
    }

    public function postApproveStudent(Request $request)
    {
        $s_id = $request->id;
        $student = User::where('id', $s_id)->first();
        if ($student) {
            $student->approve = "yes";
            $student->save();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Student was not found!");
        }
    }

    public function postDeclineStudent(Request $request)
    {
        $s_id = $request->id;
        $student = User::where('id', $s_id)->first();
        if ($student) {
            if (FileHelp::exists(public_path("/storage/images/" . $student->image))) {
                FileHelp::delete(public_path("/storage/images/" . $student->image));
            }
            $student->delete();
            return redirect()->back();
        } else {
            return redirect()->back()->with("error", "Student was not found!");
        }
    }
}
