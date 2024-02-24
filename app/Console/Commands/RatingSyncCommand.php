<?php

/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Employee;
use App\Models\RMS\WpEmpRms;
use App\Models\STD\StaffsServiceInfoFeedbacks;
use App\Models\STD\TeacherServiceFeedback;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class RatingSyncCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "SyncRating";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Rating of an Employee";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        try {

            $employees = Employee::where('activestatus', 1)->where('id', '<>', 1)->get();

            // dd($employees->first());

            foreach ($employees as $emp) {
                $type = 'faculty';


                $authId = $emp->id;

                //        $authId = '362';
                $employee = Employee::where('id', $authId)->where('groups', 'like', '%' . $type . '%')->first();


                if ($employee) {

                    // if ($employee->total_rating_provider != null && $employee->average_rating != null) {
                        $wpEmpRms = WpEmpRms::whereEmail1($employee->office_email)->first();

                        $teacherServiceFeedback = TeacherServiceFeedback::with('teacherServiceFeedbackDetails')
                            ->withCount([
                                'teacherServiceFeedbackDetails AS totalPoint' => function ($query) {
                                    $query->select(\DB::raw("SUM(point)"));
                                }
                            ])->whereTeacherId($wpEmpRms->id)->get();


                        $totalRatingProvider = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->count();
                        $totalCategory = TeacherServiceFeedback::whereTeacherId($wpEmpRms->id)->sum('total_category');


                        $totalNumberCategory = 0.00;
                        if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
                            $totalNumberCategory = $totalCategory / $totalRatingProvider;
                        }

                        $totalNumberPoint = 0.00;
                        if (!($teacherServiceFeedback->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
                            $totalNumberPoint = $teacherServiceFeedback->sum('totalPoint') / $totalRatingProvider;
                        }

                        $averageRating = 0.00;
                        if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
                            $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
                        }



                        $employee->total_rating_provider = $totalRatingProvider;
                        $employee->average_rating = number_format($averageRating, 2);


                        $employee->save();
                        $this->info('Rating Saved for ' . $employee->name . ' and id: ' . $employee->id);
                    // }
                } 
                else 
                // all staffs rating start
                {
                    $staffDetails = StaffsServiceInfoFeedbacks::withCount([
                        'staffServiceInfoFeedbackDetails AS totalPoint' => function ($query) {
                            $query->select(\DB::raw("SUM(point)"));
                        }
                    ])->whereEmployeeId($authId)->get();

                    $totalRatingProvider = StaffsServiceInfoFeedbacks::whereEmployeeId($authId)->count();
                    $totalCategory = StaffsServiceInfoFeedbacks::whereEmployeeId($authId)->sum('total_category');


                    $totalNumberCategory = 0.00;
                    if (!($totalCategory == 0 && $totalRatingProvider == 0)) {
                        $totalNumberCategory = $totalCategory / $totalRatingProvider;
                    }


                    $totalNumberPoint = 0.00;
                    if (!($staffDetails->sum('totalPoint') == 0 && $totalRatingProvider == 0)) {
                        $totalNumberPoint = $staffDetails->sum('totalPoint') / $totalRatingProvider;
                    }

                    $averageRating = 0.00;
                    if (!($totalNumberPoint == 0 && $totalNumberCategory == 0)) {
                        $averageRating = number_format($totalNumberPoint / $totalNumberCategory, 2);
                    }
                    // all staffs rating end

                    // dd($emp);

                    $emp->total_rating_provider = $totalRatingProvider;
                    $emp->average_rating = number_format($averageRating, 2);

                    $emp->save();

                    $this->info('Rating Saved for ' . $emp->name . ' and id: ' . $emp->id);
                }
            }
        } catch (\Exception $exception) {
            $type = 'faculty';

            $authId = $emp->id;
            //        $authId = '362';


            $info = response()->json(['error' => $exception->getMessage()], 400);

            $this->info($info . $emp->id);
        }
    }
}
