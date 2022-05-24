<?php

namespace App\Jobs\Pbx;

use App\Http\Controllers\Job\SmsController;
use App\Jobs\Job;
use App\Models\Attendance\AttendenceMessage;

class WeeklySmsJob extends Job
// implements ShouldQueue
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $response = Curl::to($url . '/interval')->returnResponseObject()->asJson(true)->get();
        $response = AttendenceMessage::get()->pluck('schedule');

        if ($response) {
            if (in_array('weekly', $response)) {
                $service = new SmsController();
                $service->weeklySms();
            }
        }
    }
}