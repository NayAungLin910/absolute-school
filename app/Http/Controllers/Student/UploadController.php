<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function upload($id)
    {
        $form = Form::where('id', $id)->with('subject', 'upload')->first();
        if ($form) {
            $subject_id = $form->subject->id;
            $cur_user = "";
            $sub_ids = [];
            $cur_user = User::where('id', Auth::user()->id)->with('batch.subject')->first();
            if (count($cur_user->batch) > 0) {
                foreach ($cur_user->batch[0]->subject as $s) {
                    $sub_ids[] = $s->id;
                }
            } else {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            }
            if (!in_array($subject_id, $sub_ids)) {
                return redirect('/teacher-student/your-subjects')->with("error", "Unauthorized access!");
            } else {
                return view('student.upload.create-upoad', compact('form'));
            }
        } else {
            return redirect('/teacher-student/your-subjects')->with("error", "Form not found!");
        }
    }
}
