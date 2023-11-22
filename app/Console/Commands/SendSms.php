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
use App\Models\Students\SmsSchedule;
use App\Models\Students\Student;
use App\OfficeNumber;
use App\Traits\MetronetSmsTraits;

/**
 * Class deletePostsCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class SendSms extends Command
{
    use  MetronetSmsTraits;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "SendSms";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Sms Send All Student";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $todayTime = strtotime( date("Y-m-d") ) ;
        $startTime = strtotime('+09 hours 00 minutes',$todayTime);
        $endTime = strtotime('+19 hours 00 minutes',$todayTime);
        $time = time();        

        if( $time < $startTime || $endTime < $time){
            return "Time up!";
           
        }else{        
             
            $sms = SmsSchedule::first(); 
            $numbers = Student::where('status','NEW')->take($sms->limit)->get();                
        
            if(count($numbers)>0){               

                
                $officeNumber = OfficeNumber::pluck('phone'); 
                
                foreach($numbers as $number){
              
                    try {
                        $index = array_rand($officeNumber->toArray(), 1);
    
                       $random_officer_number = $officeNumber[$index];              
    
                       $newMessage = str_replace('#phone#',  $random_officer_number, $sms->message);
                     
                        $response = $this->send_sms($number->number, $newMessage);
                        $res = json_decode($response);
    
                        $number->update([
                            'message'=> $newMessage,
                            'status'=>$res->message,
                            // 'error'=>$res->error,
                            // 'message_id'=> $res->message_id,
                            'date'=> date("Y-m-d H:i:s") 
                        ]);                      

                        $this->info('Sms Send To:'. $number->number.' id:'.$number->id.'  date:'.date("Y-m-d H:i:s"). ' response message:'.$response);
                        
                    } catch (\Exception $e) {
                        $this->info('Sms Send Failed:'. $number->number.' id:'.$number->id.'  date:'.date("Y-m-d H:i:s"). ' erorr message:'.$e->getMessage());
                    }   
                   
                }

            }else{
                $this->info('Please Insert Numbers');
            }          
           
            
            
        }
    }
}