<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Hostel;
use App\Models\HMS\Room;
use App\Models\HMS\Seat;
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
        $data  = $this->validate($request,
            [
                'name'          => 'required',
                'location'      => 'required',
                'type'          => 'required|in:boys,girls',
                'image'         => 'nullable',
                'description'   => 'nullable',
            ],
            [
                'name.required'     => 'Hostel name is required.',
                'location.required' => 'Hostel location is required.',
                'type.required'     => 'Hostel Type is required.',
            ]
        );

        $data['created_by'] = $request->auth->id;

        $hostel = Hostel::create($data);

        try {

            $hostel_file_name = '';

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $extention = strtolower($image->getClientOriginalExtension());

                $hostel_file_name = '/images/hostel/' . 'hostel_photo_' . $hostel->id . '.' . $extention;

                $request->file('image')->move(storage_path('/images/hostel/'), $hostel_file_name);

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

    function updateData(Request $request, $id)
    {
        $data  = $this->validate($request,
            [
                'name'          => 'required',
                'location'      => 'required',
                'type'          => 'required|in:boys,girls',
                'image'         => 'nullable',
                'description'   => 'nullable',
            ],
            [
                'name.required'     => 'Hostel name is required.',
                'location.required' => 'Hostel location is required.',
                'type.required'     => 'Hostel Type is required.',
            ]
        );


        $hostel = Hostel::findOrFail($id);

        $data['created_by'] = $hostel->created_by;
        $data['updated_by'] = $request->auth->id;

        $hostel->update($data);

        try {
            $hostel_file_name = '';

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extention = strtolower($image->getClientOriginalExtension());

                $hostel_file_name = 'images/hostel/' . 'hostel_photo_file_' . $hostel->id . '.' . $extention;

                $request->file('image')->move(storage_path('/images/hostel/'), $hostel_file_name);
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
        return response()->json(['error' => 'Update Failed.'], 400);
    }


//
    public function show($id)
    {
        $hostel = Hostel::find($id);
 	    return  response()->json($hostel);
    }

//    public function update(Request $request, $id)
//    {
//        $data  = $this->validate($request,
//            [
//                'name'          => 'required',
//                'location'      => 'required',
//                'type'          => 'required|in:boys,girls',
//                'created_by'    => 'required',
//                'updated_by'    => 'required',
//            ],
//            [
//                'name.required'         => 'Hostel name is required.',
//                'location.required'     => 'Hostel location is required.',
//                'type.required'         => 'Hostel Type is required.',
//                'created_by.required'   => 'You are not authenticated to create',
//                'updated_by.required'   => 'You are not authenticated to update',
//            ]
//        );
//
//        $hostel = Hostel::find($id);
//
//        $hostel->update($data);
//
//        if (!empty($hostel->id)) {
//            return response()->json($hostel, 201);
//        }
//        return response()->json(['error' => 'Update Failed.'], 400);
//
//    }

    public function delete($id)
    {
        $hostel = Hostel::find($id);
        if (!empty($hostel)) {

            try {
                $hostel->delete();
                return response()->json(['Deleted Successfully.'], 200);

            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
        return response()->json(NULL, 404);
    }



    function bed_types($id)
    {
        $seats      = Seat::where('hostel_id', $id)->where('available', '<>', 0)->get();
        $bed_types  = $seats->groupBy('bed_type');
        return  response()->json($bed_types->keys());
    }



    public function rooms($hostel)
    {
        $rooms = Room::where('hostel_id', $hostel)->get();

        return  response()->json($rooms);
    }
}

