<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Hostel;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    function index()
    {
    	$hostels = Hostel::get();
 	    return  response()->json($hostels);
    }

    function store(Request $request)
    {
        if($request->hasFile('image'))
        {
            return ['has image'];
        }else {
            
        return ['no image',$request->all()];
        }
        $data  = $this->validate($request, 
            [
                'name'          => 'required',
                'location'      => 'required',
                'type'          => 'required|in:boys,girls',
                'user_id'       => 'required',
                'description'   => 'nullable',
            ],
            [
                'name.required'     => 'Hostel name is required.',
                'location.required' => 'Hostel location is required.',
                'type.required'     => 'Hostel Type is required.',
                'user_id.required'  => 'Hostel Type is required.',
            ]
        );

        $info = [
            'name'          => $data['name'],
            'location'      => $data['location'],
            'type'          => $data['type'],
            'created_by'    => $data['user_id'],
        ];

        $hostel = Hostel::create($info);


        try {


            if (!$request->hasFile('image')->isValid()) {
                return response()->json(['error' => 'No Image File Selected'], 400);
            }

            $hostel_file_name = '';

            if ($request->hasFile('image')->isValid()) {

                $image = $request->file('image');
                $extention = strtolower($image->getClientOriginalExtension());

                $hostel_file_name = 'images/' . 'hostel_photo_file_' . $employee->id . '.' . $extention;

                $request->file('image')->move(storage_path('/images'), $hostel_file_name);
                $hostel->image = $hostel_file_name;

            }


            $hostel->save();

            return response()->json(NULL, 200);

        } catch (\PDOException $e) {
            \Log::error($e);
            return response()->json(['error' => 'Hostel Image Upload Fail'], 400);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Hostel Image Upload Fail'], 400);
        }


        if (!empty($hostel->id)) {
            return response()->json($hostel, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function show($id)
    {
        $hostel = Hostel::find($id);
 	    return  response()->json($hostel);
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request, 
            [
                'name'          => 'required',
                'location'      => 'required',
                'type'          => 'required|in:boys,girls',
                'created_by'    => 'required',
                'updated_by'    => 'required',
            ],
            [
                'name.required'         => 'Hostel name is required.',
                'location.required'     => 'Hostel location is required.',
                'type.required'         => 'Hostel Type is required.',
                'created_by.required'   => 'You are not authenticated to create',
                'updated_by.required'   => 'You are not authenticated to update',
            ]
        );

        $hostel = Hostel::find($id);

        $hostel->update($data);

        if (!empty($hostel->id)) {
            return response()->json($hostel, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);

    }

    public function delete($id)
    {
        $hostel = Hostel::find($id);
        if (!empty($hostel)) {
            if ($hostel->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}

