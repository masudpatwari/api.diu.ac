<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    function index()
    {
    	$rooms = Room::with('hostel')->get();

 	    return  response()->json($rooms);
    }

    function store(Request $request)
    {
        $data  = $this->validate($request, 
            [
                'hostel_id' => 'required|numeric',
                'room_number'  => 'required',
                'capacity'      => 'required|numeric',
            ],
            [
                'hostel_id.required'     => 'Hostel name is required.',
                'hostel_id.number'     => 'Hostel Id must be number',
                'room_number.required' => 'Room Number is required.',
                'capacity.required'     => 'Room capacity is required.',
                'capacity.numeric'     => 'Room number must be numeric.',
            ]
        );

        $data['created_by'] = $request->auth->id;

        $room = Room::create($data);

        if (!empty($room->id)) {
            return response()->json($room, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function show($id)
    {
        $room = Room::find($id);
 	    return  response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request, 
            [
                'hostel_id' => 'required|numeric',
                'room_number'  => 'required',
                'capacity'      => 'required|numeric',
            ],
            [
                'hostel_id.required'     => 'Hostel name is required.',
                'hostel_id.number'     => 'Hostel Id must be number',
                'room_number.required' => 'Room Number is required.',
                'capacity.required'     => 'Room capacity is required.',
                'capacity.numeric'     => 'Room number must be numeric.',
            ]
        );

        $room = Room::find($id);

        $data['created_by'] = $room->created_by;
        $data['updated_by'] = $request->auth->id;

        $room->update($data);

        if (!empty($room->id)) {
            return response()->json($room, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);

    }

    public function delete($id)
    {
        $room = Room::find($id);
        if (!empty($room)) {

            try {
                $room->delete();
                return response()->json(['Delete Successful.'], 200);

            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
        return response()->json(NULL, 404);
    }
}
