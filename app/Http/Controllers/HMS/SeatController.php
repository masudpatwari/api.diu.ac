<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    function index()
    {
    	$seats = Seat::with('room')->get();
 	    return  response()->json($seats);
    }

    function store(Request $request)
    {
        $data  = $this->validate($request, 
            [
                'room_id'   => 'required|numeric',
                'bed_type'  => 'required|string',
                'user_id'   => 'required',
            ],
            [
                'room_id.required'      => 'Room number is required.',
                'room_id.number'        => 'Room number must be number',
                'bed_type.required'     => 'Seat Number is required.',
                'bed_type.string'       => 'Seat capacity is required.',
                'user_id.required'      => 'You are not authenticated to create',
            ]
        );

        $info = [
            'room_id'       => $data['room_id'],
            'bed_type'      => $data['bed_type'],
            'created_by'    => $data['user_id'],
        ];

        $seat = Seat::create($info);

        if (!empty($seat->id)) {
            return response()->json($seat, 201);
        }
        return response()->json(['error' => 'Insert Failed.'], 400);
    }

    public function show($id)
    {
        $seat = Seat::find($id);
 	    return  response()->json($seat);
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request, 
            [
                'room_id'       => 'required|numeric',
                'bed_type'      => 'required|string',
                'created_by'    => 'required',
                'updated_by'    => 'required',
            ],
            [
                'room_id.required'      => 'Room number is required.',
                'room_id.number'        => 'Room number must be number',
                'bed_type.required'     => 'Bed Type is required.',
                'bed_type.sting'        => 'Bed Type must be sting.',
                'created_by.required'   => 'You are not authenticated to create',
                'updated_by.required'   => 'You are not authenticated to update',
            ]
        );

        $seat = Seat::find($id);

        $seat->update($data);

        if (!empty($seat->id)) {
            return response()->json($seat, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);

    }

    public function delete($id)
    {
        $seat = Seat::find($id);
        if (!empty($seat)) {
            if ($seat->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }
}
