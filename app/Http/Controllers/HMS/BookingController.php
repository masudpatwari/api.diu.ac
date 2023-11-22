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
use App\Models\HMS\Hostel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentEmailVerify;
use App\Mail\ResetStudentPassword;



class BookingController extends Controller
{


    public function index(Request $request)
    {

        $bookings = Booking::with('hostel', 'room')
            ->where('status', 0)    // Not Approved
            ->get(['id', 'issue_date', 'bed_type', 'room_id', 'hostel_id', 'student_id', 'student_name', 'reg_no', 'advanced_amount']);

        return  response()->json($bookings);
    }


    public function store(Request $request)
    {
        $data = $this->validate(
            $request,
            [
                'student_id' => 'required|numeric',
                'hostel_id' => 'required|numeric',
                'room_id' => 'required|numeric',
                'bed_type' => 'required|string',
                'student_name' => 'required',
                'advanced_amount' => 'nullable',
                'receipt_no' => 'nullable',
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
        $data['issue_date'] = $request->issue_date;

        try {
            $isBooked = Booking::where('student_id', $data['student_id'])->first();

            if (empty($isBooked)) {

                $booking = Booking::create($data);
                if ($data['advanced_amount'] != null) {
                    return 'advance amount';
                }
            } else {
                return response()->json(['error' => 'This Student Booked a Room already.'], 400);
            }


            if (!empty($booking->id)) {
                return response()->json($booking, 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function show()
    {
        $bookings = Booking::with('hostel', 'room')
            ->where('status', 1)    // Approved
            ->get();

        return response()->json($bookings);
    }


    public function pay(Request $request)
    {
        // return $request->all();

        $this->validate(
            $request,
            [
                'student_id' => 'required|numeric',
                'receipt_no' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ],
            [
                'student_id.number' => 'Student ID must be number'
            ]
        );

        $data['date'] = $request->date;
        $data['created_by'] = $request->auth->id;
        $data['transactionable_type'] = 'Rent';
        $data['transactionable_id'] = $request->booking_id;
        $data['user_id'] = $request->student_id;
        $data['amount'] = $request->amount;
        $data['receipt_no'] = $request->receipt_no;
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

        $data['booking'] = $booking = booking::
        where(function ($q) use ($query) {
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

              $paid_amount = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Rent Collection')->sum('amount');

            $data['total_due'] = $shift->due_amount + $rent_after_shift - $paid_amount;
            $data['paid_amount'] = $paid_amount ?? 0;

            return response()->json($data, 201);
        } else {
            $issue_date = $booking->issue_date;
        }



        if ($booking) {
            
            $rent = [];
            $diff_in_months = $this->monthsDifference($issue_date, null);

            $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

             $data['total_months'] = $diff_in_months + 1;
       //   dd($booking->hostel_id,$booking->bed_type);
            // all rent of his seat
            // return $booking->bed_type;
               $all_rent = Rent::where('bed_type', $booking->bed_type)->where('hostel_id', $booking->hostel_id)
                ->oldest('start_date')->get();

            if ($all_rent->count() > 1) {
                //filter effected month rent changes
                 $effected_rent = $all_rent->filter(function ($value, $key) use ($booking, $issue_date) {
                    if(is_null($value['end_date'])){
                        $value['end_date']= Carbon::now()->format('Y-m-d');
                        
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
            
            $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Rent Collection')->sum('amount');

            $data['total_due'] = $total_rent - $data['paid_amount'];

            return response()->json($data, 201);
        } else {
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
                    'receipt_no' => $booking->receipt_no,
                    'purpose' => 'Booking Advance',
                    'transactionable_type' => 'Booking',
                    'transactionable_id' => $booking->id,
                    'created_by' => $request->auth->id
                ]);
            }

            if ($seat->available - 1 >= 0) {
                $seat->update([
                    'available' => $seat->available - 1
                ]);
            } else {
                $seat->update([
                    'available' => 0
                ]);
            }
        });
    }

    public function delete($id)
    {
        $booking = Booking::find($id);

        if ($booking->status) {
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
        $data = $this->validate(
            $request,
            [
                'student_id' => 'required|numeric',
                'hostel_id' => 'required|numeric',
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

    public function bookingEdit($query)
    {
        $data['student'] = Booking::where('reg_no',  $query)
            ->orWhere('reg_no', 'LIKE', "%{$query}")
            ->first();

        return $data;
    }
    public function bookingUpdateDate(Request $request)
    {
        $this->validate(
            $request,
            [
                'issue_date' => 'required'
            ]

        );
        Booking::where('reg_no', '=', $request->reg_no)->update(['issue_date' => $request->issue_date]);
        return response()->json(['Issue Date successfully Updated'], 200);
    }

    public function DueCalculation($query)
    {
         $students = Booking::with('hostel', 'room')->where(['status'=> 1,'hostel_id'=>$query])->get();
        foreach ($students as $student) {
            $due = $this->info($student->reg_no);
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
        }

        return response()->json($data, 200);
    }

    public function accountStatement($query)
    {    

        $student = Booking::with('hostel', 'room', 'transection')
            ->where('reg_no', $query)
            ->orWhere('reg_no', 'LIKE', "%{$query}")
            ->get();       
            

        $data['account-info'] = $student;
        $data['balance'] = $this->info($student[0]['reg_no']);

        return response()->json($data, 200);
      

    }

    public function releaseStudent($query)
    {
        $shift = Shift::where('reg_no', $query)->where('status', 1)->first();
        $booking = Booking::where('reg_no', $query)->where('status', 1)->first();
        //  return $shift->bed_type;


        if ($shift) {
            $seat = Seat::where([
                'room_id' => $shift->room_id,
                'bed_type' => $shift->bed_type,
            ])->first();

            DB::transaction(function () use ($booking, $seat, $shift) {
                $booking->update([
                    'status' => 3, // Release
                ]);
                $shift->update([
                    'status' => 3, // Release
                ]);

                $seat->update([
                    'available' => $seat->available + 1
                ]);
            });

            return response()->json(['student Successfully Release'], 200);
        }

        if ($booking) {
            $seat = Seat::where([
                'room_id' => $booking->room_id,
                'bed_type' => $booking->bed_type,
                'hostel_id' => $booking->hostel_id
            ])->first();

            DB::transaction(function () use ($booking, $seat, $shift) {
                $booking->update([
                    'status' => 3, // Release
                ]);
                $shift->update([
                    'status' => 3, // Release
                ]);

                $seat->update([
                    'available' => $seat->available + 1
                ]);
            });
            return response()->json(['student Successfully Release'], 200);
        }
    }

    public function hostelCurrentDue($query)
    {
        $booking = Booking::where('student_id', $query)->where('status', 1)->first();
        if ($booking) {
            $due = $this->info($booking->reg_no);
            $jsonData = $due->getContent();
            $totalDue  = json_decode($jsonData, true);
            $currentDue = $totalDue['total_due'];
            $data['hostel-due'] = $currentDue;
            return response()->json($data, 200);
        }
    }







    public function hostelTestDue($query)
    {

    
        // $book = booking::where('issue_date','2022-11-01')->get();
        // // return $book;

        // foreach($book as $value){
        //    echo Shift::where('reg_no',$value->reg_no)->first() ."\n";
        // }



      
           $data['booking']= $booking = booking::where('status', 1)
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
            $data['shift'] = $shift;
            $data['total month'] =  $this->monthsDifference($shift->shift_date, null) + 1;
            $all_rent = Rent::where('bed_type', $shift->bed_type)->where('hostel_id', $shift->hostel_id)
                ->oldest('start_date')->get();

            $data['rent'] = $all_rent;

            $data['booking_date'] = Carbon::parse($data['booking']->issue_date)->format('d M Y');

            $paid_amount = Transaction::where('user_id', $shift->student_id)->where('purpose', 'Rent Collection')->sum('amount');

            $data['total_due'] = $shift->due_amount + $rent_after_shift - $paid_amount;
            $data['paid_amount'] = $paid_amount ?? 0;

            return response()->json($data, 201);
        } else {
            $issue_date = $booking->issue_date;
        }



        if ($booking) {
            $rent = [];
            $diff_in_months = $this->monthsDifference($issue_date, null);

            $data['booking_date'] = Carbon::parse($issue_date)->format('d M, Y');

            $data['total_months'] = $diff_in_months + 1;

            $rent_per_month = Rent::where('bed_type', $booking->bed_type)->where('hostel_id', $booking->hostel_id)->first()->monthly_fee;

            $data['rent'] = $rent_per_month;
            $paid_amount = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Rent Collection')->sum('amount');
            $data['paid_amount'] = $paid_amount;
            $data['due_amount'] = $data['total_months'] * $rent_per_month - $paid_amount;


            return $data;
        }
    }

    public function receiptEdit($query){
       $student = Booking::where('reg_no', $query)             
            ->orWhere('reg_no', 'LIKE', "%{$query}")
            ->first();

            return Transaction::where(['user_id'=>$student->student_id])->get();
            

    }
    public function receiptUpdate(Request $request){
        $userData = $request->input('users');

        foreach ($userData as $userId => $data) {
            // Assuming User is your model representing the users table
            $user = Transaction::find($userId);
    
            if ($user) {
                $user->update([
                    'receipt_no' => $data['receipt_no'],
                    'date' => $data['date'],
                    'amount' => $data['amount'],
                ]);
            }
        }
        return response()->json(['Update Successfully Done'], 200);
             
 
    }
    

     public function studentPortalHostelDue($student_id){      
         $booking = Booking::with('hostel')->where(['student_id'=>$student_id])->first();
         $data['account_info']= Transaction::where(['user_id'=>$student_id])->get();
        $rent = Rent::where(['hostel_id'=>$booking->hostel_id,'bed_type'=>$booking->bed_type])->get();

        $due = $this->info($booking->reg_no);
        
        $data['paid_amount']= $due->original['paid_amount'] ?? null;
        $data['total_due']= $due->original['total_due'] ?? null;
        $data['hostel']= $booking->hostel->name ?? null;
        $data['rent']= $rent ?? null;
        return response()->json($data, 200);

     }



     public function mailCheck(){
       
        $email = 'omorfaruk5020@gmail.com';
          $student = Student::where('email', $email)->first();
           $token = $this->generate_token( $student );
        
        $mail =  Mail::to($email)->send(new StudentEmailVerify($token));

        // $mail = Mail::to($email)->send(new ResetStudentPassword($token));
      
        return 'mail send successfully';
       
     }


     private function generate_token( $student )
     {
         $token_string = $student->ID . '.0.0.0.0.' . $student->PASSWORD .'.0.0.0.0.' . $student->EMAIL . uniqid() . time();
         return encrypt($token_string);
     }


}
