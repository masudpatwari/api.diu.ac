<?php

namespace App\Http\Controllers\INTL;

use App\Http\Controllers\Controller;
use App\Models\INTL\ForeignStudent;
use Illuminate\Http\Request;
use App\Models\INTL\StudentMedia;
use App\Http\Resources\intl\ForeignStudentDocResource;

class IntlStudentsDocController extends Controller
{

    public function uploadFiles(Request $request)
    {
        $this->validate($request, 
            [
                'user_id' => ['required', 'integer'],
                'title.*' => ['required', ],
                'file.*' => ['required','mimes:doc,docx,pdf,jpeg,jpg,png','max:10240'], // 10240 = 1MB
            ]
        );


        $files = $request->file('file');
        $user_id = $request->user_id;

        $foreignStudent = ForeignStudent::where('user_id',$user_id)->first();

        if ( ! $foreignStudent ) {
        	return response()->json(['message'=>'Student not found!', $user_id], 400);
        }
        
        if($request->hasFile('file'))
        {
            foreach ($files as $key=>$file) {
                // $file->store('users/' . $this->user->id . '/messages');
                $extension = $file->getClientOriginalExtension();
                $title = $request->title[$key];
                $file_name = $user_id . '-' .$title . '.' . $extension;
                $file->move(storage_path('images/foreign_student_doc'), $file_name);
                
                StudentMedia::create([
                    'user_id' => $user_id,
                    'title' => $title,
                    'filename' => $file_name,
                    'extension' => $extension,
                ]);
            }
        }

        return  ForeignStudentDocResource::collection(StudentMedia::where('user_id', $user_id)->get());

    }

    public function getAllFiles( int $userId )
    {
    	$media = StudentMedia::where('user_id', $userId)->get();
        return  ForeignStudentDocResource::collection($media);
    }

    public function removeFile($userId, $studnetMediaId)
    {
    	$media = StudentMedia::where('user_id', $userId)->where('id', $studnetMediaId)->first();
        
        $fileName = $media->filename;
        $filePath = storage_path('images/foreign_student_doc') .'/'. $fileName;

        
    	@unlink( $filePath );
        $media->delete();

        $medias = StudentMedia::where('user_id', $userId)->get();
    	return  ForeignStudentDocResource::collection($medias);
        

    }

}