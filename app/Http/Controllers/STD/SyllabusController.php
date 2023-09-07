<?php

namespace App\Http\Controllers\STD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Syllabus;
use App\Http\Resources\MaterialSyllabusResource;
use App\Http\Resources\MaterialSyllabusEditResource;

class SyllabusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $syllabus = Syllabus::orderBy('id', 'desc')->get();
        if (!empty($syllabus))
        {
            return MaterialSyllabusResource::collection($syllabus);
        }
        return response()->json(NULL, 404);
    }

    public function find_syllabus(Request $request)
    {
        $this->validate($request, 
            [
                'department_id' => 'required',
            ]
        );
        $department = $request->input('department_id');

        $syllabus = Syllabus::where('department', $department)->where('published', 'published');

        $syllabus = $syllabus->orderBy('id', 'desc')->get();
        if (!empty($syllabus))
        {
            return MaterialSyllabusResource::collection($syllabus);
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
                'syllabus_name' => 'required',
                'department_id' => 'required',
                'published' => 'required|in:draft,published',
                'feature' => 'in:true,false',
                'material_file' => 'required|mimes:pdf|max:10240',
            ]
        );

        $syllabus_array = [
            'name' => $request->input('syllabus_name'),
            'department' => $request->input('department_id'),
            'published' => $request->input('published'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'feature' => ($request->input('feature')) ? 1 : 0,
        ];
        
        $syllabus = Syllabus::create($syllabus_array);

        if(!empty($syllabus->id))
        {
            $this->upload_material_file('Syllabus', $syllabus->id, $request);
            return response()->json($syllabus, 201);
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
        $syllabus = Syllabus::find($id);
        if (!empty($syllabus))
        {
            return new MaterialSyllabusEditResource($syllabus);
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
                'syllabus_name' => 'required',
                'department_id' => 'required',
                'published' => 'required|in:draft,published',
                'feature' => 'in:true,false',
                'material_file' => 'mimes:pdf|max:10240',
            ]
        );

        $syllabus_array = [
            'name' => $request->input('syllabus_name'),
            'department' => $request->input('department_id'),
            'published' => $request->input('published'),
            'description' => $request->input('description'),
            'short_description' => $request->input('short_description'),
            'feature' => ($request->input('feature')) ? 1 : 0,
        ];

        $syllabus = Syllabus::where('id', $id)->update($syllabus_array);

        if(!empty($syllabus))
        {
            $this->delete_upload_material_file('Syllabus', $id);
            $this->upload_material_file('Syllabus', $id, $request);
            return response()->json($syllabus, 201);
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
        $delete = Syllabus::find($id);
        if (!empty($delete)) {
            $this->delete_upload_material_file('Syllabus', $id);
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
        $filename = 'Syllabus_'.$id.'.pdf';
        if (file_exists($path.$filename)) {
            $headers = [
                'Content-Type' => 'application/pdf',
            ];
            return response()->download( storage_path('educationMaterial').'/'.$filename, $filename, $headers );
        }
        return response()->json(['error' => 'File Not Found.'], 400);
    }
}
