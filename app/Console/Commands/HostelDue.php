<?php

/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\HMS\Rent;
use App\Models\HMS\Shift;
use App\Models\HMS\Booking;
use Illuminate\Http\Request;
use App\Models\HMS\Transaction;
use App\Http\Controllers\Controller;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class HostelDue extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "HostelDue";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Calculate hostel due";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $todayTime =  date("Y-m-d");;
        $students = Booking::with('hostel', 'room')->where(['status' => 1])->get();
        foreach ($students as $student) {
            $due = $this->getBookingInfo($student->reg_no);

            if($due->original['total_due'] > 999){  

                $data['date'] = $todayTime;
                $data['created_by'] = 222;
                $data['transactionable_type'] = 'Late fee';
                $data['transactionable_id'] = $student->id;
                $data['user_id'] = $student->student_id;
                $data['amount'] = -500;
                $data['receipt_no'] = $student->student_id.'-'.$todayTime;
                $data['purpose'] = 'Late fee';

                Transaction::create($data);
                $this->info('Fine Inserted_'.$student->student_id);



            }

            // if ($due->original['total_due'] > 999) {

            //     $data[] = [

            //         'total_due' => $due->original['total_due'] ?? null,
            //     ];
            // }

            // $totalElements = count($data);
            // $this->info($totalElements);
        }

       






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

            $paid_amount = Transaction::where('user_id', $booking->student_id)
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
            $diff_in_months = $this->monthsDifference($issue_date, null);

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

            // $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)->where('purpose', 'Rent Collection')->sum('amount');

            $data['paid_amount'] = Transaction::where('user_id', $booking->student_id)
                ->where(function ($query) {
                    $query->where('purpose', 'Rent Collection')
                        ->orWhere(function ($query) {
                            $query->where('purpose', 'Late fee')
                                ->where('amount', -500);
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
            $rent_per_month = Rent::where('bed_type', $bed_type)->where('hostel_id', $hostel_id)->first()->monthly_fee;

            $total_rent = $data['total_months'] * $rent_per_month;
        }

        return $total_rent;
        //        }
    }
}
