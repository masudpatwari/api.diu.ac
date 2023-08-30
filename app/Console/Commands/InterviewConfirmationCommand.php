<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Mail\InterviewConfirmationMail;
use App\Mail\InterviewConfirmationMail1;
use App\Resume;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class InterviewConfirmationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "InterviewConfirmation";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Image from ORACLE to API Server";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $resumes = Resume::where('a_status', 3)->get();

        foreach ($resumes as $key => $resume)
        {

            if($resume)
            {
                if($key % 2 == 0)
                {
//                    Mail::to($resume->email)->send(new InterviewConfirmationMail($resume));
//                    Info('ok');
//                    $this->info(('Interview Confirmation Mail for ok Send Successfully: '. $resume->name));
                }else{

//                    Mail::to($resume->email)->send(new InterviewConfirmationMail1($resume));
//                    $this->info('Interview Confirmation Mail for 12 PM Send Successfully: '. $resume->name);
                }


            }else{
                $this->info('Mail Send Fail: '. $resume);
            }
        }
    }
}
