<?php

namespace App\Http\Controllers\HMS;


use App\Http\Controllers\Controller;
use App\Models\HMS\Booking;
use App\Models\HMS\Hostel;
use App\Models\HMS\Rent;
use App\Models\HMS\Room;
use App\Models\HMS\Seat;
use App\Models\HMS\Shift;
use App\Models\HMS\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\ShiftResource;
use Illuminate\Support\Facades\DB;

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
                'available'  => 'nullable|numeric',
            ],
            [
                'hostel_id.required'      => 'Room number is required.',
                'room_id.required'      => 'Room number is required.',
                'room_id.number'        => 'Room number must be number',
                'bed_type.required'     => 'Seat Number is required.',
                'bed_type.string'       => 'Seat capacity is required.',
                'available.numeric'       => 'Available Seat must be numeric.',
            ]
        );

        $data['created_by'] = $request->auth->id;

        $room = Room::find($data['room_id']);

//        return
        $seat_type_exist = Seat::where(['bed_type' => $data['bed_type'], 'hostel_id' => $data['hostel_id'] , 'room_id' => $data['room_id']])->first();

        $room_capacity = $room->capacity;

        try {
            if(!$seat_type_exist)
            {
                $seat = Seat::create($data);

                return response()->json($seat, 200);
            }

            $total_seat = $seat_type_exist->available + $request->available;

            if($total_seat > $room_capacity)
            {
                return response()->json(['Seat Capacity Exceeded'], 400);
            }

            $seat_type_exist->update([
                'available'     => $total_seat,
                'updated_by'    => $request->auth->id
            ]);

            return response()->json(['Seat Updated'], 200);

        }catch (\Exception $e)
        {
            return response()->json(['error' => $e->getMessage()], 400);
        }

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


    function bed_types()
    {
        $seats = Seat::get();
        $bed_types = $seats->groupBy('bed_type');
        return  response()->json($bed_types->keys());
    }


    public function bookings($query)
    {
        $booking = Shift::where('student_name',  $query)
            ->orWhere('reg_no', $query)
            ->orWhere('reg_no', 'LIKE' , "%{$query}")
            ->latest('shift_date')
            ->where('status', 1)
            ->first();

        if(empty($booking))
        {
            $booking = Booking::where('student_name',  $query)
                ->orWhere('reg_no', $query)
                ->orWhere('reg_no', 'LIKE' , "%{$query}")
                ->first();
        }


        if (!empty($booking) && $booking->status == 1) {


            $data['booking'] = $booking->load('room');

            $gender = Hostel::find($booking->room->hostel_id)->type;

            if($gender == 'girls')
            {
                $data['hostel']     = Hostel::where('type', 'girls')->get();
            }else
            {
                $data['hostel']     = Hostel::where('type', 'boys')->get();
            }

            return response()->json($data);
        }
        return response()->json(NULL, 404);
    }


    public function shifts()
    {
        $shifts = ShiftResource::collection(Shift::with('oldSeat', 'newSeat', 'newSeat.hostel')->get());

        return response()->json($shifts);
    }

    public function deleteMigration($id)
    {
        $shift = Shift::find($id);


        if($shift->status)
        {
            return response()->json(['error' => 'Failed to delete. Migration Approved Already!'], 400);
        }

        if (!empty($shift)) {
            if ($shift->delete()) {
                return response()->json(['Migration deleted successfully!'], 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }

        return response()->json(NULL, 404);
    }


    public function approveMigration(Request $request, $id)
    {
        $shift = Shift::findorFail($id);

        $latest_shifting = Shift::where('student_id', $shift->student_id)->get();

        if($latest_shifting->count() > 1)
        {
            // rent calculation after shifting
            $booking = Booking::find($shift->booking_id);
            $last_shifting = Shift::where('student_id', $shift->student_id)->latest('shift_date')->first();
            $previous_shifting = Shift::where('student_id', $shift->student_id)->latest('shift_date')->skip(1)->first();
            $rent = $this->rentCalculation($previous_shifting->shift_date, $last_shifting->shift_date, $previous_shifting->bed_type);

            $rent += $previous_shifting->due_amount;
        }else{
            // rent calculation from booking date to shifting date.
            $booking = Booking::find($shift->booking_id);
            $rent = $this->rentCalculation($booking->issue_date, $shift->shift_date, $booking->bed_type);
        }

        try {

            $exception = DB::connection('hostel')->transaction(function () use($shift, $request, $rent){

                $shift->oldSeat->increment('available');

                $shift->update([
                    'approved_by'   => $request->auth->id,
                    'status'        => 1,
                    'due_amount'    => $rent ?? 0
                ]);

                $shift->newSeat->decrement('available');
            });

        }
        catch(\Exception $e) {
            return response([$e->getMessage()], 500);
        }
    }




    public function rentCalculation($issue_date, $shift_date, $bed_type)
    {

//        dd($issue_date, $shift_date, $bed_type);
//        if($booking)
//        {
            $rent = [];

            $diff_in_months = $this->monthsDifference($issue_date, $shift_date);

//            dd($diff_in_months);

            $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

//            $data['total_months'] = $diff_in_months + 1;

            $all_rent = Rent::where('bed_type', $bed_type)
                ->oldest('start_date')->get();


//        dd($diff_in_months, $all_rent);

            if($all_rent->count() > 1)
            {

                $effected_rent = $all_rent->filter(function($value, $key) use($issue_date) {
                    if ($value['end_date'] >= $issue_date) {
                        return true;
                    }else if($value['end_date'] == null) {
                        return true;
                    }
                });


                foreach($effected_rent as $key => $partial_rent)
                {
                    // $row_rent = $partial_rent->whereDate('start_date', '<=', $booking->issue_date)
                    //                             ->whereDate('end_date', '>=', $booking->issue_date)->first();

                    if(($partial_rent->end_date) != null and $partial_rent->start_date <= $issue_date and $partial_rent->end_date >= $issue_date)
                    {
                        // return response()->json($partial_rent, 201);
                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent->end_date);

                        if($diff_in_months == 0)
                        {
                            $from = Carbon::createFromFormat('Y-m-d', $issue_date);
                            $to = Carbon::createFromFormat('Y-m-d', $partial_rent->end_date);
                            $days = $to->diffInDays($from);

                            if($days > 0)
                            {
                                $new_rent =  ($diff_in_months + 1) * $partial_rent->monthly_fee;
                            }


                        }else {
                            $new_rent =  ($diff_in_months) * $partial_rent->monthly_fee;
                        }

                        array_push($rent, $new_rent);

                    }else if(($partial_rent->end_date) != null and $partial_rent->start_date >= $issue_date and $partial_rent->end_date >= $issue_date)
                    {

                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent->end_date);

                        // return response()->json([$partial_rent, $diff_in_months], 201);
                        if($diff_in_months == 0)
                        {
                            $new_rent =  ($diff_in_months + 1) * $partial_rent->monthly_fee;
                        }else
                        {
                            $new_rent =  ($diff_in_months) * $partial_rent->monthly_fee;
                        }

                        // return response()->json($diff_in_months, 201);
                        array_push($rent, $new_rent);

                    }else if(($partial_rent->end_date) == null and $partial_rent->start_date < now())
                    {
                        $diff_in_months = $this->monthsDifference($partial_rent->start_date, null);

                        $new_rent =  ($diff_in_months + 1) * $partial_rent->monthly_fee;

                        array_push($rent, $new_rent);
                    }
                    // else {

                    //     $date1 = Carbon::createFromFormat('Y-m-d', $partial_rent->start_date);
                    //     $date2 = now();

                    //     $result = $date1->gt($date2);
                    //     // return response()->json($partial_rent->start_date > now(), 201);
                    //     return response()->json($result, 201);

                    // }

                    // $new_rent =  ($diff_in_months + 1) * $partial_rent->monthly_fee;

                    // array_push($rent, $new_rent);
                }
                // return response()->json($rent, 201);

                $total_rent = array_sum($rent);
            }

            else
            {
                $rent_per_month = Rent::where('bed_type', $bed_type)->first()->monthly_fee;

                $total_rent = $diff_in_months * $rent_per_month;
            }

            return $total_rent;
    }


    function monthsDifference($start, $end=null)
    {
        if(!$end)
        {
            $to     = Carbon::now();
        }else {
            $to   = Carbon::createFromFormat('Y-m-d', $end);
        }

        $from   = Carbon::createFromFormat('Y-m-d', $start);

        return $diff_in_months = $to->diffInMonths($from);

    }

}
