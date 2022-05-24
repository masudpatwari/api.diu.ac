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
class ConvocationImageSyncCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "ConvocationImageSync";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sync Image from Database for Convocation Students";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $students_reg_from_convocation = StudentConvocation::whereNull('image_url')->pluck('reg_code_one','id');
 
        

        foreach ($students_reg_from_convocation as $convocation_id => $reg_no)
        {
            $student_id = Student::where('REG_CODE', $reg_no)->value('id');
            
            $image = "student_profile_photo_{$student_id}.jpg";

            if(Storage::disk('image_path')->exists($image))
            {
                $get_image = Storage::disk('image_path')->get($image);

                Storage::disk('image_path')->put("convocations/{$convocation_id}.jpg", $get_image);

                StudentConvocation::find($convocation_id)->update([
                    'image_url' => "{$convocation_id}.jpg"
                ]);


                $this->info('Convocation Student Image retrieved '."{$convocation_id}.jpg");

            }else{
                $url = (env('RMS_API_URL').'/get_student_by_reg_code/'.$reg_no);

                $response = Curl::to($url)
                ->asJson(true)
                ->get();

                try {
                    if($response['id'])
                    {
                        try
                        {
                            $image = "student_profile_photo_{$response['id']}.jpg";

                            $get_image = Storage::disk('image_path')->get($image);

                            Storage::disk('image_path')->put("convocations/{$convocation_id}.jpg", $get_image);

                            StudentConvocation::find($convocation_id)->update([
                                'image_url' => "{$convocation_id}.jpg"
                            ]);


                            $this->info('Convocation Student Image retrieved '."{$convocation_id}.jpg");
                        }
                        catch(\Exception $e)
                        {
                            $this->info(' Reg No '.$reg_no.', Image Not Found in Oracle');
                        }

                    }
                } catch (\Exception $e) {
                    $this->info(' Reg No '.$reg_no.', Image Not Found in Oracle');
                }


            }
        }
    }
}
