<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;

use App\Models\Convocation\StudentConvocation;
use App\Models\STD\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Ixudra\Curl\Facades\Curl;


/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ConvocationPhoneNoSyncCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "ConvocationPhoneSync";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Phone No from Database for Convocation Students";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $students_reg_from_convocation = StudentConvocation::whereRaw('LENGTH(contact_no) < 2')->pluck('reg_code_one','id');


        foreach ($students_reg_from_convocation as $convocation_id => $reg_no) {
            $no = Student::where('REG_CODE', $reg_no)->value('PHONE_NO');


            if ($no) {
                $no = substr($no, -11);

                $phone = '+88' . $no;
                StudentConvocation::where('id', $convocation_id)->update(['contact_no' => $phone]);


                $this->info('Convocation Student Phone No retrieved from mysql '.$reg_no);
            } else {
                $url = (env('RMS_API_URL') . '/get_student_by_reg_code/' . $reg_no);


                $response = Curl::to($url)
                    ->asJson(true)
                    ->get();


                if ($response) {
                    try{
                        $no = substr($response['mobile'], -11);
                        $phone = '+88' . $no;

                        StudentConvocation::where('id', $convocation_id)->update(['contact_no' => $phone]);

                        $this->info('Convocation Student Phone No retrieved from oracle '.$reg_no);

                    }catch (\Exception $e){
                        $this->info('Convocation Student Phone No not retrieved from oracle '.$reg_no);
                    }


                }

            }


        }

    }
}
