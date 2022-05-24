<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Question;
use App\Http\Resources\MaterialQuestionResource;
use App\Http\Resources\MaterialQuestionEditResource;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $questions = Question::orderBy('id', 'desc')->get();
        if (!empty($questions))
        {
            return MaterialQuestionResource::collection($questions);
        }
        return response()->json(NULL, 404);
    }

    public function find_questions(Request $request)
    {
        $this->validate($request, 
            [
                'department_id' => 'required',
                'semester' => 'numeric',
            ]
        );
        $department = $request->input('department_id');
        $semester = $request->input('semester');

        $questions = Question::where('department', $department)->where('published', 'published');
        if (!empty($semester))
        {
            $questions->where('semester', $semester);
        }

        $questions = $questions->orderBy('id', 'desc')->get();
        if (!empty($questions))
        {
            return MaterialQuestionResource::collection($questions);
        }
        return response()->json(NULL, 404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'course_name' => 'required',
                'course_code' => 'required',
                'department_id' => 'required',
                'semester' => 'required|numeric',
                'session' => 'required',
                'published' => 'required|in:draft,published',
                'material_file' => 'required|mimes:pdf|max:500',
            ]
        );

        $questions_array = [
            'course_name' => $request->input('course_name'),
            'course_code' => $request->input('course_code'),
            'department' => $request->input('department_id'),
            'semester' => $request->input('semester'),
            'published' => $request->input('published'),
            'session' => $request->input('session'),
            'description' => $request->input('description'),
            'created_by' => $request->auth->id,
        ];

        $questions = Question::create($questions_array);

        if(!empty($questions->id))
        {
            $this->upload_material_file('Question', $questions->id, $request);
            return response()->json($questions, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $questions = Question::find($id);
        if (!empty($questions))
        {
            return new MaterialQuestionEditResource($questions);
        }
        return response()->json(NULL, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, 
            [
                'course_name' => 'required',
                'course_code' => 'required',
                'department_id' => 'required',
                'semester' => 'required|numeric',
                'session' => 'required',
                'published' => 'required|in:draft,published',
                'material_file' => 'mimes:pdf|max:500',
            ]
        );

        $questions_array = [
            'course_name' => $request->input('course_name'),
            'course_code' => $request->input('course_code'),
            'department' => $request->input('department_id'),
            'semester' => $request->input('semester'),
            'published' => $request->input('published'),
            'session' => $request->input('session'),
            'description' => $request->input('description'),
        ];

        $questions = Question::where('id', $id)->update($questions_array);

        if(!empty($questions))
        {
            $this->delete_upload_material_file('Question', $id);
            $this->upload_material_file('Question', $id, $request);
            return response()->json($questions, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $delete = Question::find($id);
        if (!empty($delete)) {
            $this->delete_upload_material_file('Question', $id);
            if ($delete->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    private function upload_material_file($type, $id, $request)
    {
        if ($request->hasFile('material_file') && $request->file('material_file')->isValid()){
            $file = $request->file('material_file');
            $extention = strtolower($file->getClientOriginalExtension());
            $fileName = 'educationMaterial/'.$type.'_'.$id.'.'.$extention;
            $request->file('material_file')->move(storage_path('educationMaterial'), $fileName);
            return true;
        }
        return false;
    }

    private function delete_upload_material_file($type, $id)
    {
        $filename = storage_path('educationMaterial').'/'.$type.'_'.$id.'.pdf';
        if (file_exists($filename)) {
            unlink($filename);
            return true;
        }
        return false;
    }

    public function download( $id, $key )
    {
        if (md5($id) != $key) {
            return response()->json(NULL, 404);
        }
        $path = storage_path('educationMaterial/');
        $filename = 'Question_'.$id.'.pdf';
        if (file_exists($path.$filename)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download( storage_path('educationMaterial').'/'.$filename, $filename, $headers );
        }
        return response()->json(['error' => 'File Not Found.'], 400);
    }
}
