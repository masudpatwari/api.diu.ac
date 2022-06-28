<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    function index()
    {
    	$seats = Seat::with('room:room_number,id','hostel:name,id')->get();
 	    return  response()->json($seats);
    }

    function store(Request $request)
    {
        $data  = $this->validate($request, 
            [
                'hostel_id'   => 'required|numeric',
                'room_id'   => 'required|numeric',
                'bed_type'  => 'required|string',
                'available'  => 'required|numeric',
            ],
            [
                'hostel_id.required'      => 'Room number is required.',
                'room_id.required'      => 'Room number is required.',
                'room_id.number'        => 'Room number must be number',
                'bed_type.required'     => 'Seat Number is required.',
                'bed_type.string'       => 'Seat capacity is required.',
                'available.required'       => 'Available Seat is required.',
            ]
        );

        $data['created_by'] = $request->auth->id;

        $seat_type_exist = Seat::where(['bed_type' => $data['bed_type'], 'hostel_id' => $data['hostel_id'] , 'room_id' => $data['room_id']])->first();

        if($seat_type_exist)
        {
            $seat_type_exist->update([
                'available'     => $seat_type_exist->available + $data['available'],
                'updated_by'    => $request->auth->id
            ]);

            return response()->json(['Seat Updated'], 400);
        }else{
            $seat = Seat::create($data);
        }

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
            ],
            [
                'room_id.required'      => 'Room number is required.',
                'room_id.number'        => 'Room number must be number',
                'bed_type.required'     => 'Bed Type is required.',
                'bed_type.sting'        => 'Bed Type must be sting.',
            ]
        );

        $seat = Seat::find($id);

        $data['created_by'] = $seat->created_by;
        $data['updated_by'] = $request->auth->id;

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

            try {
//                $seat->delete();
                // check seat booked or not before delete
                return response()->json(['Delete Successful.'], 200);

            }catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
        return response()->json(NULL, 404);
    }
}
