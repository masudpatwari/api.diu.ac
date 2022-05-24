<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\STD\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class StudentImageController extends Controller
{

    public function update(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:jpeg,jpg,png|max:1024',
        ]);

        $image = $request->file('file');
        if ($image) {
            $file_name = "STD{$request->id}.JPG";
            Storage::disk('ftp')->put($file_name, fopen($image, 'r+'));

            $this->storeImage($request, $request->id);
        }

        return response()->json(['message' => 'Student image upload successfully'], 200);

    }

    public function storeImage($request, $student_id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extention = strtolower($file->getClientOriginalExtension());
            $filename = 'student_profile_photo_' . $student_id . '.' . $extention;


            try {
                Storage::disk('image_path')->put($filename, fopen($file, 'r+'));

            } catch (\PDOException $e) {
                \Log::error(print_r($e->getMessage(), true));
            }
        }
    }

}

