<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\LectureSheet;
use App\Http\Resources\MaterialLectureSheetResource;
use App\Http\Resources\MaterialLectureSheetEditResource;

class LectureSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lecture_sheets = LectureSheet::orderBy('id', 'desc')->get();
        if (!empty($lecture_sheets))
        {
            return MaterialLectureSheetResource::collection($lecture_sheets);
        }
        return response()->json(NULL, 404);
    }

    public function find_lecture_sheets(Request $request)
    {
        $this->validate($request, 
            [
                'department_id' => 'required',
                'semester' => 'numeric',
            ]
        );
        $department = $request->input('department_id');
        $semester = $request->input('semester');

        $lecture_sheets = LectureSheet::where('department', $department)->where('published', 'published');
        if (!empty($semester))
        {
            $lecture_sheets->where('semester', $semester);
        }

        $lecture_sheets = $lecture_sheets->orderBy('id', 'desc')->get();
        if (!empty($lecture_sheets))
        {
            return MaterialLectureSheetResource::collection($lecture_sheets);
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
                'department_id' => 'required',
                'semester' => 'required|numeric',
                'published' => 'required|in:draft,published',
                'course_code' => 'required',
                'session' => 'required',
                'submission_date' => 'required',
                'prepared_by' => 'required',
                'material_file' => 'required|mimes:pdf|max:1024',
            ]
        );

        $lecture_sheets_array = [
            'course_name' => $request->input('course_name'),
            'course_code' => $request->input('course_code'),
            'department' => $request->input('department_id'),
            'semester' => $request->input('semester'),
            'published' => $request->input('published'),
            'session' => $request->input('session'),
            'submission_date' => $request->input('submission_date'),
            'prepared_by' => $request->input('prepared_by'),
            'created_by' => $request->auth->id,
        ];

        $lecture_sheets = LectureSheet::create($lecture_sheets_array);

        if(!empty($lecture_sheets->id))
        {
            $this->upload_material_file('Lecture_Sheet', $lecture_sheets->id, $request);
            return response()->json($lecture_sheets, 201);
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
        $lecture_sheets = LectureSheet::find($id);
        if (!empty($lecture_sheets))
        {
            return new MaterialLectureSheetEditResource($lecture_sheets);
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
                'department_id' => 'required',
                'semester' => 'required|numeric',
                'published' => 'required|in:draft,published',
                'course_code' => 'required',
                'session' => 'required',
                'submission_date' => 'required',
                'prepared_by' => 'required',
                'material_file' => 'mimes:pdf|max:1024',
            ]
        );

        $lecture_sheets_array = [
            'course_name' => $request->input('course_name'),
            'course_code' => $request->input('course_code'),
            'department' => $request->input('department_id'),
            'semester' => $request->input('semester'),
            'published' => $request->input('published'),
            'session' => $request->input('session'),
            'submission_date' => $request->input('submission_date'),
            'prepared_by' => $request->input('prepared_by'),
        ];

        $lecture_sheets = LectureSheet::where('id', $id)->update($lecture_sheets_array);

        if(!empty($lecture_sheets))
        {
            $this->delete_upload_material_file('Lecture_Sheet', $id);
            $this->upload_material_file('Lecture_Sheet', $id, $request);
            return response()->json($lecture_sheets, 201);
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
        $delete = LectureSheet::find($id);
        if (!empty($delete)) {
            $this->delete_upload_material_file('Lecture_Sheet', $id);
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
        $filename = 'Lecture_Sheet_'.$id.'.pdf';
        if (file_exists($path.$filename)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download( storage_path('educationMaterial').'/'.$filename, $filename, $headers );
        }
        return response()->json(['error' => 'File Not Found.'], 400);
    }
}
