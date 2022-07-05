<?php

namespace App\Http\Controllers\HMS;

use App\Models\HMS\Rent;
use App\Models\HMS\Seat;
use App\Models\HMS\Shift;
use App\Models\HMS\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\STD\Student;
use App\Models\HMS\Booking;
use Illuminate\Support\Facades\DB;


class BookingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $bookings = Booking::with('hostel', 'room')
            ->where('status', 0)    // Not Approved
            ->get(['id', 'issue_date', 'bed_type', 'room_id', 'hostel_id', 'student_id', 'student_name', 'reg_no', 'advanced_amount']);

        return  response()->json($bookings);
//        $bookings = Booking::get();
//
//
//        $bookings = $bookings->map(function($item) use($students){
//
//            return [
//                'issue_date'    => $item->issue_date,
//                'bed_type'      => $item->bed_type,
//                'room_id'       => $item->room_id,
//                'hostel_id'     => $item->hostel_id,
//                'student'       => $student_info
//            ];
//        });
//
//        if (!empty($bookings)) {
//            return response()->json($bookings);
//        }
//        return response()->json(NULL, 404);
    }


    public function store(Request $request)
    {
        $data = $this->validate($request,
            [
                'student_id' => 'required|numeric',
                'hostel_id' => 'required|numeric',
                'room_id' => 'required|numeric',
                'bed_type' => 'required|string',
                'student_name' => 'required',
                'advanced_amount' => 'nullable',
                'reg_no' => 'required',
                'issue_date' => 'required'
            ],
            [
                'student_id.number' => 'Student ID must be number',
                'hostel_id.number' => 'Hostel ID must be number',
                'room_id.number' => 'Room number must be number',
                'bed_type.string' => 'Seat capacity is required.'
            ]
        );

        $data['created_by'] = $request->auth->id;

        try {
            $isBooked = Booking::where('student_id', $data['student_id'])->first();

            if (empty($isBooked)) {
                $booking = Booking::create($data);
            } else {
                return response()->json(['error' => 'This Student Booked a Room already.'], 400);
            }


            if (!empty($booking->id)) {
                return response()->json($booking, 201);
            }
        }catch(\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function show(){
        $bookings = Booking::with('hostel', 'room')
            ->where('status', 1)    // Approved
            ->get();

        return response()->json($bookings);
    }


    public function pay(Request $request)
    {
        $this->validate($request,
            [
                'student_id' => 'required|numeric',
                'amount' => 'required',
            ],
            [
                'student_id.number' => 'Student ID must be number'
            ]
        );

        $data['date'] = Carbon::now()->format('Y-m-d');
        $data['created_by'] = $request->auth->id;
        $data['transactionable_type'] = 'Booking';
        $data['transactionable_id'] = $request->booking_id;
        $data['user_id'] = $request->student_id;
        $data['amount'] = $request->amount;
        $data['purpose'] = 'Rent Collection';

        $payment = Transaction::create($data);

        if (!empty($payment->id)) {
            return response()->json(['Rent collected successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed'], 400);
        }
    }


    public function info($query)
    {
        $data['booking'] = $booking = Booking::where('student_name',  $query)
            ->orWhere('reg_no', $query)
            ->orWhere('reg_no', 'LIKE' , "%{$query}")
            ->first();

//return
        $shift = Shift::where('student_name',  $query)
            ->orWhere('reg_no', $query)
            ->orWhere('reg_no', 'LIKE' , "%{$query}")
            ->latest('shift_date')
            ->where('status', 1)
            ->first();

        if($shift)
        {
            $rent_after_shift = $this->rentPay($shift->shift_date, $shift->bed_type);

//            $data['booking'] = Booking::find($shift->booking_id);

            $data['booking_date'] = Carbon::parse($data['booking']->issue_date)->format('d M Y');

            $paid_amount = Transaction::where('user_id', $booking->student_id)->sum('amount');

            $data['total_due'] = $shift->due_amount + $rent_after_shift - $paid_amount;

//            return $shift->booking_id;
            return response()->json($data, 201);

        }else {
            $issue_date = $booking->issue_date;
        }

        if($booking)
        {
            $rent = [];
            $diff_in_months = $this->monthsDifference($issue_date, null);

            $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

            $data['total_months'] = $diff_in_months + 1;
            $all_rent = Rent::where('bed_type', $booking->bed_type)
                ->oldest('start_date')->get();


//            return [$data, $all_rent];
            if($all_rent->count() > 1)
            {
                $effected_rent = $all_rent->filter(function($value, $key) use($booking, $issue_date) {
                    if ($value['end_date'] >= $issue_date) {
                        return true;
                    }else if($value['end_date'] == null) {
                        return true;
                    }
                });


                foreach($effected_rent as $key => $partial_rent)
                {
                    $row_rent = $partial_rent->whereDate('start_date', '<=', $issue_date)
                        ->whereDate('end_date', '>=', $issue_date)->first();

                    if(($partial_rent->end_date) != null and $partial_rent->start_date <= $issue_date and $partial_rent->end_date >= $issue_date)
                    {
                        // return response()->json($partial_rent, 201);
                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent->end_date);

                        if($diff_in_months == 0)
                        {
                            $from = Carbon::createFromFormat('Y-m-d', $issue_date);
                            $to = Carbon::createFromFormat('Y-m-d', $partial_rent->end_date);
                            $days = $to->diffInDays($from);

                            $new_rent =  ($diff_in_months + 1) * $partial_rent->monthly_fee;

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

                    }else if(($partial_rent->end_date) == null and $partial_rent->start_date < Carbon::now())
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
            }else
            {
                try {
                    $rent_per_month = Rent::where('bed_type', $booking->bed_type)->first()->monthly_fee;

                    $total_rent = $data['total_months'] * $rent_per_month;

                }catch(\Exception $e)
                {
                    return response()->json(['error' => 'Rent not set for '.$booking->bed_type], 400);

                }
            }


            $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)->sum('amount');

            $data['total_due'] = $total_rent - $data['paid_amount'];

            return response()->json($data, 201);
        }else {
            return response()->json(['error' => 'Insert Failed.'], 400);
        }
    }


    public function approve(Request $request, $id)
    {
        $booking = Booking::find($id);

        $seat = Seat::where([
                'room_id' => $booking->room_id,
                'bed_type' => $booking->bed_type,
                'hostel_id' => $booking->hostel_id
            ])
            ->first();


        DB::transaction(function () use ($booking, $request, $seat) {
            $booking->update([
                'seat_id' => $seat->id,
                'status' => 1,
                'approved_by' => $request->auth->id,
            ]);

            if ($booking->advanced_amount > 0) {
                Transaction::create([
                    'user_id' => $booking->student_id,
                    'date' => $booking->issue_date,
                    'amount' => $booking->advanced_amount,
                    'purpose' => 'booking_advance',
                    'transactionable_type' => 'Booking',
                    'transactionable_id' => $booking->id,
                    'created_by' => $request->auth->id
                ]);
            }

            if($seat->available - 1 >= 0) {
                $seat->update([
                    'available' => $seat->available - 1
                ]);
            }else{
                $seat->update([
                    'available' => 0
                ]);
            }
        });
    }

    public function delete($id)
    {
        $booking = Booking::find($id);

        if($booking->status)
        {
            return response()->json(['error' => 'Already Booked'], 400);
        }

        if (!empty($booking)) {
            if ($booking->delete()) {
                return response()->json(['Deleted Successfully'], 200);
            }
        }
        return response()->json(['error' => 'Delete Failed'], 400);
    }


    function approved()
    {
        $bookings = Booking::with('hostel', 'room')
            ->where('status', 1)    // Approved
            ->get();

        return response()->json($bookings);
    }


    // function bed_types()
    // {
    // 	$seats = Seat::get();
    //     $bed_types = $seats->groupBy('bed_type');
    //     return  response()->json($bed_types->keys());
    // }


    function monthsDifference($start, $end = null)
    {
        if (!$end) {
            $to = Carbon::now();
        } else {
            $to = Carbon::createFromFormat('Y-m-d', $end);
        }

        $from = Carbon::createFromFormat('Y-m-d', $start);

        return $diff_in_months = $to->diffInMonths($from);

    }

    public function migrate(Request $request)
    {
        $data = $this->validate($request,
            [
                'student_id' => 'required|numeric',
                'room_id' => 'required|numeric',
                'bed_type' => 'required|string',
                'student_name' => 'required',
                'reg_no' => 'required',
                'shift_date' => 'required'
            ],
            [
                'student_id.number' => 'Student ID must be number',
                'hostel_id.number' => 'Hostel ID must be number',
                'room_id.number' => 'Room number must be number',
                'bed_type.string' => 'Seat capacity is required.'
            ]
        );

        $booking = Booking::find($request->booking_id);

        $seat = Seat::where([
            'room_id' => $booking->room_id,
            'bed_type' => $booking->bed_type,
            'hostel_id' => $booking->hostel_id
        ])->first();

        $to = Seat::where([
            'room_id' => $data['room_id'],
            'bed_type' => $data['bed_type'],
            'hostel_id' => $request->hostel_id
        ])->first();

        $data['from'] = $seat->id;
        $data['to'] = $to->id;
        $data['created_by'] = $request->auth->id;
        $data['booking_id'] = $request->booking_id;

        $shift = Shift::create($data);


        if (!empty($shift->id)) {
            return response()->json($shift, 201);
        }

        return response()->json(['error' => 'Migration Failed'], 400);
    }

    public function rentPay($issue_date, $bed_type)
    {
//        if ($booking) {
        $rent = [];
//            return
        $diff_in_months = $this->monthsDifference($issue_date, null);

        $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

        $data['total_months'] = $diff_in_months + 1;


        $all_rent = Rent::where('bed_type', $bed_type)
                ->oldest('start_date')->get();

//        dd($data['total_months'], $all_rent);
//            dd($data, $all_rent, $booking);
            if ($all_rent->count() > 1) {

                $effected_rent = $all_rent->filter(function ($value, $key) use ($issue_date) {
                    if ($value['end_date'] >= $issue_date) {
                        return true;
                    } else if ($value['end_date'] == null) {
                        return true;
                    }
                });


                foreach ($effected_rent as $key => $partial_rent) {
                    $row_rent = $partial_rent->whereDate('start_date', '<=', $issue_date)
                        ->whereDate('end_date', '>=', $issue_date)->first();

                    if (($partial_rent->end_date) != null and $partial_rent->start_date <= $issue_date and $partial_rent->end_date >= $issue_date) {
                        // return response()->json($partial_rent, 201);
                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent->end_date);

                        if ($diff_in_months == 0) {
                            $from = Carbon::createFromFormat('Y-m-d', $issue_date);
                            $to = Carbon::createFromFormat('Y-m-d', $partial_rent->end_date);
                            $days = $to->diffInDays($from);

                            $new_rent = ($diff_in_months + 1) * $partial_rent->monthly_fee;

                        } else {
                            $new_rent = ($diff_in_months) * $partial_rent->monthly_fee;
                        }

                        array_push($rent, $new_rent);

                    } else if (($partial_rent->end_date) != null and $partial_rent->start_date >= $issue_date and $partial_rent->end_date >= $issue_date) {

                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent->end_date);

                        // return response()->json([$partial_rent, $diff_in_months], 201);
                        if ($diff_in_months == 0) {
                            $new_rent = ($diff_in_months + 1) * $partial_rent->monthly_fee;
                        } else {
                            $new_rent = ($diff_in_months) * $partial_rent->monthly_fee;
                        }

                        // return response()->json($diff_in_months, 201);
                        array_push($rent, $new_rent);

                    } else if (($partial_rent->end_date) == null and $partial_rent->start_date < Carbon::now()) {
                        $diff_in_months = $this->monthsDifference($partial_rent->start_date, null);

                        $new_rent = ($diff_in_months + 1) * $partial_rent->monthly_fee;

                        array_push($rent, $new_rent);
                    }
                }

                $total_rent = array_sum($rent);
            } else {
                // dd($current_seat, Rent::where('bed_type', $current_seat)->first());
                $rent_per_month = Rent::where('bed_type', $bed_type)->first()->monthly_fee;

                $total_rent = $data['total_months'] * $rent_per_month;
            }

            return $total_rent;
//        }
    }

    public function rentCalculation(){

    }

}
