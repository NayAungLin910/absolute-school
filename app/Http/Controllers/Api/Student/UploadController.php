<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File as FileHelp;

class UploadController extends Controller
{
    public function postUpload(Request $request)
    {
        $v = Validator::make($request->all(), [
            "form" => "required",
            "uploads" => "required",
            "uploads.*" =>  "max:20000",
            "user_id" => "required",
        ],);

        if ($v->fails()) {
            return response()->json([
                "success" => false,
                "status" => 500,
                "data" => $v->errors(),
            ]);
        }

        $form = json_decode($request->form);

        $uploads = Upload::where("user_id", $request->user_id)->where("form_id", $form->id)->get();
        if ($uploads) {
            foreach ($uploads as $u) {
                if (FileHelp::exists(public_path("/storage/uploads/" . $u->file_path))) {
                    FileHelp::delete(public_path("/storage/uploads/" . $u->file_path));
                }
                $u->delete();
            }
        }

        foreach ($request->file("uploads") as $f) {
            $name = $f->getClientOriginalName();
            $file_path = uniqid() . $f->getClientOriginalName();
            $f->move(public_path("/storage/uploads"), $file_path);

            Upload::create([
                "name" => $name,
                "file_path" => $file_path,
                "form_id" => $form->id,
                "user_id" => $request->user_id,
            ]);
        }

        return response()->json([
            "success" => true,
            "status" => 200,
            "data" => "Files have been submitted!",
        ]);
    }
}
