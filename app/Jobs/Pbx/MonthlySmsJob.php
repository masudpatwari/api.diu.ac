<?php

namespace App\Jobs\Pbx;

use App\classes\smsWithPBX;
use App\Http\Controllers\Job\SmsController;
use App\Jobs\Job;
use App\Models\Attendance\AttendenceMessage;
use App\Models\PBX\SmsSendResponse;
use Ixudra\Curl\Facades\Curl;

class MonthlySmsJob extends Job
// implements ShouldQueue
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $response = AttendenceMessage::get()->pluck('schedule');


        if ($response) {
            if (in_array('monthly', $response)) {
                $service = new SmsController();
                $service->monthlySms();
            }
        }
    }
}