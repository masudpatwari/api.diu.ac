<?php

namespace App\Http\Controllers\INTL;

use App\Http\Controllers\Controller;
use App\Models\INTL\Meet;
use Illuminate\Http\Request;
use App\Http\Resources\intl\MeetForeignStudentResource;

class MeetController extends Controller
{
    public function index()
    {
        
    }


    
    public function create()
    {
  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, 
            [
                'student_id' => ['required', 'integer'],
                'comment' => ['required',],
                'next_date' => ['nullable','date'],
                'image' => ['nullable','mimes:jpeg,jpg,png','max:500',]
            ],
            [
                'image.*.required' => 'Please upload an image',
                'image.*.mimes' => 'Only jpeg images are allowed',
                'image.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ]
        );


        $meet = Meet::create([
            "student_id" => $request->student_id,
            "comment" => $request->comment,
            "meet_by" => $request->auth->id,
            // "next_date" => $request->next_date,
        ]);
		
		$meet->next_date = $request->next_date ==''?null: $request->next_date;
		$meet->save();
		
        if( $request->has('image') ) {
            $image = $request->file('image');
            $imageName = $meet->id . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('images/meet_image'), $imageName);

            $meet->extension = $image->getClientOriginalExtension();
            $meet->save();
        } 
        return response()->json(['message'=>'Saved successfully']);
    }

    public function show($student_id)
    {
    	$meets = Meet::where('student_id', (int) $student_id)
    		->orderBy('id','desc')
    		->get();
        return MeetForeignStudentResource::collection( $meets );
    }
}
