<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Hostel;
use App\Models\HMS\Room;
use App\Models\HMS\Seat;
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
                'user_id'   => 'required',
            ],
            [
                'hostel_id.required'     => 'Hostel name is required.',
                'hostel_id.number'     => 'Hostel Id must be number',
                'room_number.required' => 'Room Number is required.',
                'capacity.required'     => 'Room capacity is required.',
                'capacity.numeric'     => 'Room number must be numeric.',
                'user_id.required'  => 'You are not authenticated to create',
            ]
        );

        $info = [
            'hostel_id'          => $data['hostel_id'],
            'room_number'      => $data['room_number'],
            'capacity'          => $data['capacity'],
            'created_by'    => $data['user_id'],
        ];

        $room = Room::create($info);

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
                'created_by'    => 'required',
                'updated_by'    => 'required',
            ],
            [
                'hostel_id.required'     => 'Hostel name is required.',
                'hostel_id.number'     => 'Hostel Id must be number',
                'room_number.required' => 'Room Number is required.',
                'capacity.required'     => 'Room capacity is required.',
                'capacity.numeric'     => 'Room number must be numeric.',
                'created_by.required'   => 'You are not authenticated to create',
                'updated_by.required'   => 'You are not authenticated to update',
            ]
        );

        $room = Room::find($id);

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
            if ($room->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
   
    function available_rooms($hostel, $bed_type)
    {
        // return $bed_type;
     
        $seats  = Seat::with('room')
        ->where(['hostel_id' => $hostel, 'bed_type' => $bed_type])
        ->where('available', '>',0)
        ->get();
       

        if($seats)
        {
            return response()->json($seats->pluck('room', 'id'));
        }else {
            return response()->json(['error' => 'No Rooms Available.'], 404);
        }
    }



    public function available_seats($hostel_id){

        $seat =  Seat::with('room.hostel')->where(['hostel_id'=>$hostel_id])->get();
        $seat->transform(function($item){
            return [
                'hostel'=>$item->hostel->name ?? null,
                'bed_type'=>$item->bed_type ?? null,
                'room_number'=>$item->room->room_number ?? null,
                'seat_capacity'=>$item->room->capacity?? null,
                'seat_available'=>$item->available ?? null,

            ];
        });
        return  $seat;

    


   }
}
