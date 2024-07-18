<?php

namespace App\Console;

use App\Http\Controllers\Job\SmsController;
use App\Models\Attendance\AttendenceMessage;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CourseMaterialCommand::class,
        Commands\LiaisonOfficersSendSms::class,
        Commands\TranscriptCommand::class,
        Commands\ImportForeignStdToIntlSite::class,
        Commands\ImportSmsCommand::class,
        Commands\ImportCSVNumberCommand::class,
        Commands\AutoSupportTicketCompleteCommand::class,
        Commands\AutoSupportTicketAssignCommand::class,
        Commands\AttendanceSmsCommand::class,
        Commands\ImageSyncCommand::class,
        Commands\RatingSyncCommand::class,
        Commands\ConvocationImageSyncCommand::class,
        Commands\ConvocationPhoneNoSyncCommand::class,
        Commands\SendSms::class,
        Commands\HostelDue::class,
        Commands\StudentStoreForScholarship::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // $interval = AttendenceMessage::value('schedule');

//        $interval = Storage::disk('attendance_info')->get('attendance');
//
//
//        if($interval == 'daily')
//        {
//            $schedule->command('attendance:sms')->daily()
//                ->appendOutputTo('schedule.log');
//        }elseif($interval == 'monthly')
//        {
//            $schedule->command('attendance:sms')->monthly()
//                ->appendOutputTo('schedule.log');
//        }elseif($interval == 'weekly')
//        {
//            $schedule->command('attendance:sms')->weekly()
//                ->appendOutputTo('schedule.log');
//        }

//        $schedule->command('email:campaign')->everyMinute();

    }
}
