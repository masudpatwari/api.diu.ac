<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Http\Controllers\Job\SmsController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;


class AttendanceSmsCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "attendance:sms";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Attendance Sms Process";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $smsController = new SmsController();
        $smsController->info();

//        Artisan::call('queue:work', ['--queue' => 'default,attendance_sms', '--max-time' => '3600', '--tries' => '3']);

    }
}

