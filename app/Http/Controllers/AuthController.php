<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Batch;
use App\Models\Moderator;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function adminLogin()
    {
        return view('auth.admin-login');
    }

    public function postAdminLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $admin = Admin::where("email", $request->email)->first();
        if ($admin) {
            $cre = ["email" => $request->email, "password" => $request->password];
            if (Auth::guard('admin')->attempt($cre, true)) {
                return redirect("/admin-mod/statistics")->with("success", "Logined successfully as an admin!");
            } else {
                return redirect()->back()->withErrors(["error" => "Email or password do not match!"]);
            }
        } else {
            return redirect()->back()->withErrors(["email" => "Email not found!"]);
        }
    }

    public function moderatorLogin()
    {
        return view('auth.moderator-login');
    }

    public function postModeratorLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $moderator = Moderator::where("email", $request->email)->first();

        if ($moderator && $moderator->approve == "no") {
            return redirect()->back()->withErrors(["error" => "The account has not been approved by the admin."]);
        }

        if ($moderator) {
            $cre = ["email" => $request->email, "password" => $request->password];
            if (Auth::guard('moderator')->attempt($cre, true)) {
                return redirect("/admin-mod/statistics")->with("success", "Logined successfully as a moderator!");
            } else {
                return redirect()->back()->withErrors(["error" => "Email or password do not match!"]);
            }
        } else {
            return redirect()->back()->withErrors(["email" => "Email not found!"]);
        }
    }

    public function teacherLogin()
    {
        return view('auth.teacher-login');
    }

    public function postTeacherLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $teacher = Teacher::where("email", $request->email)->first();

        if ($teacher && $teacher->approve == "no") {
            return redirect()->back()->withErrors(["error" => "The account has not been approved by the admin."]);
        }

        if ($teacher) {
            $cre = ["email" => $request->email, "password" => $request->password];
            if (Auth::guard('teacher')->attempt($cre, true)) {
                return redirect("/teacher-student/your-subjects")->with("success", "Logined successfully as a teacher!");
            } else {
                return redirect()->back()->withErrors(["error" => "Email or password do not match!"]);
            }
        } else {
            return redirect()->back()->withErrors(["email" => "Email not found!"]);
        }
    }

    public function studentLogin()
    {
        return view('auth.student-login');
    }

    public function postStudentLogin(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $student = User::where("email", $request->email)->first();

        if ($student && $student->approve == "no") {
            return redirect()->back()->withErrors(["error" => "The account has not been approved by the admin."]);
        }

        if ($student) {
            $cre = ["email" => $request->email, "password" => $request->password];
            if (Auth::attempt($cre, true)) {
                return redirect("/teacher-student/your-subjects")->with("success", "Logined successfully as a student!");
            } else {
                return redirect()->back()->withErrors(["error" => "Email or password do not match!"]);
            }
        } else {
            return redirect()->back()->withErrors(["email" => "Email not found!"]);
        }
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } else if (Auth::guard('moderator')->check()) {
            Auth::guard('moderator')->logout();
        } else if (Auth::guard('teacher')->check()) {
            Auth::guard('teacher')->logout();
        } else if (Auth::check()) {
            Auth::logout();
        }
        return redirect("/login/student")->with("info", "Please login again!");
    }

    public function moderatorRegister()
    {
        return view('auth.moderator-register');
    }

    public function postModeratorRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:moderators,email",
            "password" => "required",
        ]);

        $moderator = Moderator::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return redirect()->back()->with("success", "Account created! Please, wait for awhile for the admin to approve your account. And please try logging in after some time.");
    }

    public function teacherRegister()
    {
        return view('auth.teacher-register');
    }

    public function postTeacherRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:teachers,email",
            "image" => "required|image",
            "password" => "required",
        ]);

        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image_path = "/storage/images/" . $image_name;
        $image->move(public_path("/storage/images"), $image_name);

        $teacher = Teacher::create([
            "name" => $request->name,
            "email" => $request->email,
            "image" => $image_name,
            "password" => Hash::make($request->password),
        ]);

        return redirect()->back()->with("success", "Account created! Please, wait for awhile for the admin to approve your account. And please try logging in after some time.");
    }

    public function studentRegister()
    {
        return view('auth.student-register');
    }

    public function postStudentRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "image" => "required|image",
            "password" => "required",
        ]);

        $image = $request->file('image');
        $image_name = uniqid() . $image->getClientOriginalName();
        $image_path = "/storage/images/" . $image_name;
        $image->move(public_path("/storage/images"), $image_name);

        $student = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "image" => $image_name,
            "password" => Hash::make($request->password),
        ]);

        return redirect()->back()->with("success", "Account created! Please, wait for awhile for the admin to approve your account. And please try logging in after some time.");
    }

    public function profile()
    {
        $subject_count = 0;
        $batch_count = 0;
        $batch_name = "";
        if (Auth::guard("teacher")->check()) {
            $teacher = Teacher::where("id", Auth::guard("teacher")->user()->id)->withCount("subject")->first();
            $teacher_id = $teacher->id;
            $subject_count = $teacher->subject_count;
            $batch_count = Batch::whereHas("subject", function ($query) use ($teacher_id) {
                $query->where("teacher_id", $teacher_id);
            })->count();
        }
        if (Auth::check()) {
            $student = User::where("id", Auth::user()->id)->with("batch.subject")->first();
            if (count($student->batch) > 0) {
                $b = $student->batch[0];
                if (count($b->subject) > 0) {
                    $b = Batch::where("id", $b->id)->withCount("subject")->first();
                    $subject_count = $b->subject_count;
                }
                $batch_name = $student->batch[0]->name;
            }
        }
        return view('auth.profile', compact('subject_count', 'batch_count', 'batch_name'));
    }
}
