<?php

namespace App\Http\Controllers\HMS;


use Carbon\Carbon;
use App\Models\HMS\Rent;
use App\Models\HMS\Shift;
use App\Models\HMS\Booking;
use Illuminate\Http\Request;
use App\Models\HMS\Transaction;
use App\Http\Controllers\Controller;

class RentController extends Controller
{
    function index()
    {
        $rents = Rent::with('hostel')->orderBy('hostel_id','asc')->get();
        return  response()->json($rents);
    }

    function store(Request $request)
    {
        $data = $this->validate($request,
            [
                'hostel_id'      => 'required',
                'bed_type'      => 'required',
                'monthly_fee'   => 'required',
                'start_date'    => 'required',
            ]);
            if($request->end_date == ""){

                $data['end_date'] =  NULL;
            }else{
                $data['end_date'] = $request->end_date;
    
            }  

        
        $data['created_by'] = $request->auth->id;
       

        // $rent = Rent::where('bed_type', $request->bed_type)->whereNull('end_date')->first();

        // if($rent)
        // {
        //     $end_date = Carbon::createFromFormat('Y-m-d', $request->start_date)
        //         ->subMonth()
        //         ->endOfMonth()
        //         ->format('Y-m-d');

        //     $rent->update(['end_date' => $end_date]);
        // }

        $rent = Rent::create($data);

        // if (!empty($rent->id)) {
        //     return response()->json($rent, 201);
        // }
        return response()->json(['error' => 'Insert Successfully done.'], 201);
    }

    public function show($id)
    {
        $rent = Rent::with('hostel')->find($id);
        return  response()->json($rent);
    }

    public function update(Request $request, $id)
    {
        $data  = $this->validate($request,
            [
                'hostel_id'      => 'required',
                'bed_type'      => 'required|string',
                'monthly_fee'   => 'required|numeric',
                'start_date'    => 'required',
            ],
            [   
                
                'monthly_fee.required'      => 'Monthly Rent is required.',
                'monthly_fee.number'        => 'Monthly Rent must be number',
                'bed_type.required'         => 'Bed Type is required.',
                'bed_type.string'           => 'Bed Type is required.',
                'start_date.required'       => 'Effected Date is required.',
            ]
        );
        $rent = Rent::find($id);

        if($request->end_date == ""){

            $data['end_date'] =  NULL;
        }else{
            $data['end_date'] = $request->end_date;

        }

        $data['updated_by'] = $request->auth->id;

        $rent->update($data);

        if (!empty($rent->id)) {
            return response()->json($rent, 201);
        }
        return response()->json(['error' => 'Update Failed.'], 400);

    }

    public function destroy($id)
    {
        $rent = Rent::find($id);
        if (!empty($rent)) {
            if ($rent->delete()) {
                return response()->json(NULL, 204);
            }
            return response()->json(['error' => 'Delete Failed.'], 400);
        }
        return response()->json(NULL, 404);
    }

    public function calculate_hostel_due()
    {

        // return $todayTime =  date("Y-m-d");
         $students = Booking::with('hostel', 'room')->where(['status' => 1,'reg_no'=>'PH-34-23-127270'])->get();
        foreach ($students as $student) {
             return  $due = $this->getBookingInfo($student->reg_no);

            // if($due->original['total_due'] >999){
                $data[] = [
                    'hostel' => $student->hostel->name ?? null,
                    'room' => $student->room->room_number ?? null,
                    'bed_type' => $student->bed_type ?? null,
                    'booking_date' => $student->issue_date ?? null,
                    'student_name' => $student->student_name ?? null,
                    'reg_no' => $student->reg_no ?? null,
                    'paid_amount' => $due->original['paid_amount'] ?? null,
                    'total_due' => $due->original['total_due'] ?? null,
                ];

            // }
           
        }

        return response()->json($data, 200);
    }

    public function getBookingInfo($query)
    {

         $data['booking'] = $booking = booking::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('reg_no', $query)
                    ->orWhere('reg_no', 'LIKE', "%{$query}");
            })
            ->first();

             $shift = Shift::where('status', 1)
            ->where(function ($q) use ($query) {
                $q->where('reg_no', $query)
                    ->orWhere('reg_no', 'LIKE', "%{$query}");
            })
            ->first();

        if ($shift) {

            $rent_after_shift = $this->rentPay($shift->shift_date, $shift->bed_type, $shift->hostel_id);

            $data['booking_date'] = Carbon::parse($data['booking']->issue_date)->format('d M Y');

            // $paid_amount = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Rent Collection')->sum('amount');

            $paid_amount= Transaction::where('user_id', $booking->student_id)
                ->where(function ($query) {
                    $query->where('purpose', 'Rent Collection')
                        ->orWhere(function ($query) {
                            $query->where('purpose', 'Late fee')
                                ->where('amount', -500);
                        });
                })
                ->sum('amount');

            $data['total_due'] = $shift->due_amount + $rent_after_shift - $paid_amount;
            $data['paid_amount'] = $paid_amount ?? 0;

            return response()->json($data, 201);
        } else {
            $issue_date = $booking->issue_date;
        }



        if ($booking) {

            $rent = [];
            return  $diff_in_months = $this->monthsDifference($issue_date, null);

            $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

            $data['total_months'] = $diff_in_months + 1;
            $all_rent = Rent::where('bed_type', $booking->bed_type)->where('hostel_id', $booking->hostel_id)
                ->oldest('start_date')->get();

            if ($all_rent->count() > 1) {
                //filter effected month rent changes
                $effected_rent = $all_rent->filter(function ($value, $key) use ($booking, $issue_date) {
                    if (is_null($value['end_date'])) {
                        $value['end_date'] = Carbon::now()->format('Y-m-d');
                    }

                    if ($value['end_date'] >= $issue_date && $value['start_date'] <= Carbon::now()->format('Y-m-d')) {
                        return true;
                    }
                })->toArray();


                foreach ($effected_rent as $key => $partial_rent) {

                    $row_rent = collect($partial_rent)->where('start_date', '<=', $issue_date);

                    if (($partial_rent['end_date']) != null and $partial_rent['start_date'] <= $issue_date and $partial_rent['end_date'] >= $issue_date) {

                        $diff_in_months = $this->monthsDifference($issue_date, $partial_rent['end_date']);


                        if ($diff_in_months == 0) {
                            $from = Carbon::createFromFormat('Y-m-d', $issue_date);
                            $to = Carbon::createFromFormat('Y-m-d', $partial_rent['end_date']);
                            $days = $to->diffInDays($from);

                            $new_rent =  ($diff_in_months + 1) * $partial_rent['monthly_fee'];
                        } else {
                            $new_rent =  ($diff_in_months + 1) * $partial_rent['monthly_fee'];
                        }

                        array_push($rent, $new_rent);
                    } else if (($partial_rent['end_date']) != null and $partial_rent['start_date'] >= $issue_date and $partial_rent['end_date'] >= $issue_date) {
                        $diff_in_months = $this->monthsDifference($partial_rent['start_date'], Carbon::now() >
                            $partial_rent['end_date'] ? $partial_rent['end_date'] : Carbon::now()->format('Y-m-d'));

                        if ($diff_in_months == 0) {
                            $new_rent =  ($diff_in_months + 1) * $partial_rent['monthly_fee'];
                        } else {
                            $new_rent =  ($diff_in_months + 1) * $partial_rent['monthly_fee'];
                        }

                        array_push($rent, $new_rent);
                    } else if (($partial_rent['end_date']) == null and $partial_rent['start_date'] < Carbon::now()) {
                        $diff_in_months = $this->monthsDifference($partial_rent['start_date'], null);

                        $new_rent =  ($diff_in_months + 1) * $partial_rent['monthly_fee'];

                        array_push($rent, $new_rent);
                    }
                }
                $total_rent = array_sum($rent);
            } else {
                try {


                    $rent_per_month = Rent::where('bed_type', $booking->bed_type)->where('hostel_id', $booking->hostel_id)->first()->monthly_fee;

                    $total_rent = $data['total_months'] * $rent_per_month;
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Rent not set for ' . $booking->bed_type], 400);
                }
            }

            // return  $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Late fee')->get();
             $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)
                ->where(function ($query) {
                    $query->where('purpose', 'Rent Collection')
                        ->orWhere(function ($query) {
                            $query->where('purpose', 'Late fee');
                                
                        });
                })
                ->sum('amount');

            $data['total_due'] = $total_rent - $data['paid_amount'];

            return response()->json($data, 201);
        } else {
            return response()->json(['error' => 'Insert Failed.'], 400);
        }
    }

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

    public function rentPay($issue_date, $bed_type, $hostel_id)
    {
        //        if ($booking) {
        $rent = [];
          $diff_in_months = $this->monthsDifference($issue_date, null);

        $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

        $data['total_months'] = $diff_in_months + 1;

         $all_rent = Rent::where('bed_type', $bed_type)->where('hostel_id', $hostel_id)
            ->oldest('start_date')->get();
            // return $all_rent->count();

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

                    if ($diff_in_months == 0) {
                        $new_rent = ($diff_in_months + 1) * $partial_rent->monthly_fee;
                    } else {
                        $new_rent = ($diff_in_months) * $partial_rent->monthly_fee;
                    }

                     array_push($rent, $new_rent);
                     
                } else if (($partial_rent->end_date) == null and $partial_rent->start_date < Carbon::now()) {
                    $diff_in_months = $this->monthsDifference($partial_rent->start_date, null);

                    $new_rent = ($diff_in_months + 1) * $partial_rent->monthly_fee;

                    array_push($rent, $new_rent);
                    
                }
            }

            $total_rent = array_sum($rent);
        } else {
            $rent_per_month = Rent::where('bed_type', $bed_type)->where('hostel_id',$hostel_id)->first()->monthly_fee;

            $total_rent = $data['total_months'] * $rent_per_month;
        }

        return $total_rent;
        //        }
    }
}
