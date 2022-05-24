<?php

namespace App\Http\Controllers\Pbx;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\Pbx\SendSmsJob;
use App\Models\GOIP\Provider;
use App\Models\PBX\PbxCampaign;

class SendMsgController extends Controller
{


    public function sendSmsToStudents(Request $request)
    {

        /*$formate_date = date('Y-m-d h:i:s A', strtotime($request->date));
        dump(\Log::error(print_r([$request->all(),$formate_date],true)));*/

        $this->validate($request, 
            [
                'campaign_name' => ['unique:pbx_campaign,name','required'],
                'mobileNumbersWith88Prefix' => ['required'],
                'content' => ['required'],
                'interval' => ['required','integer','min:0'],
                'date' => ['required','date'],
                'is_custom_sms' => ['required','in:1,0'],
            ]
        );


        $providerArray = Provider::active()->pluck('name_or_number')->toArray();
//        $providerArray = Provider::whereRaw('LENGTH(prov) > 1')->pluck('prov')->toArray();
//        $providerArray = ['8801882839861', '8801839115794', '8801648172830', '8801839115839', '8801882839859'];

        $providerCount = count($providerArray);
        $providerCounter = 0;

        if ( $request->is_custom_sms==1 ) {
            $mobilenumerwith88prefixArray = explode('|', $request->mobileNumbersWith88Prefix);
        }else{
            $mobilenumerwith88prefixArray = explode(',', $request->mobileNumbersWith88Prefix);
        }

        $countMmobilenumer  = count($mobilenumerwith88prefixArray) ;
        if ( $countMmobilenumer == 1) {
            return response()->json(['message'=>'Mobile Number Text Must be comma(,) separated multiple mobile number ' . implode('|', $mobilenumerwith88prefixArray)],400);
        }

        if ( $countMmobilenumer > 10000) {
            return response()->json(['message'=>'Max 8000 number supported.'],400);
        }




        foreach ($mobilenumerwith88prefixArray as $mobileNumberWith88Prefix) {

        	if ( strpos($mobileNumberWith88Prefix, '88')!==0 ) {
        		return response()->json(['message'=> $mobileNumberWith88Prefix . ' is not valid!'], 400);
        	}
        }


        $content = $request->content;
        $interval = $request->interval;
        $date = strtotime($request->date);

        $topTimeInQueue =  (\DB::table('jobs')->max('available_at'));

        if ( $topTimeInQueue > $date) {
            return response()->json(['message'=>'Queue already full till ' . date("Y-m-d H:i:s", $topTimeInQueue)], 400);
        }

//        return [$mobilenumerwith88prefixArray,$countMmobilenumer, $mobilenumerwith88prefixArray];

//        $campain_content = [];

//        $presentTime  = Carbon::now();

        $key = 0;

//        foreach($mobilenumerwith88prefixArray as $message)
//        {
//            $info = [
//                'name' => $request->campaign_name.$key++,
//                'created_by' => $request->auth->id,
//                'count_mobile_number' => $countMmobilenumer,
//                'message' => $message,
//                'is_custom_sms' => $request->is_custom_sms,
//                'created_at' => $presentTime,
//                'updated_at' => $presentTime,
//            ];
//
//            array_push($campain_content, $info);
//        }
//
//        $campaign = PbxCampaign::insert($campain_content);
//
//        return $campaign;
//
//        return $content['content'];

 		$presentTime  = time();

        $campaign = new PbxCampaign();
        $campaign->name = $request->campaign_name;
        $campaign->created_by = $request->auth->id;
        $campaign->count_mobile_number = $countMmobilenumer;
        $campaign->message = $request->input('content');
        $campaign->is_custom_sms = $request->is_custom_sms;
        $campaign->created_at = $presentTime;
        $campaign->updated_at = $presentTime;
        $campaign->save();




        $sleep = $interval;

        $mobileNumberCounter = 0;

        $totalMessageCounter = 2000 * $providerCount;


        foreach ($mobilenumerwith88prefixArray as $mobileNumberWith88Prefix) {

            if ( $providerCounter >  $providerCount-1 ) {
                $providerCounter = 0;
            }
            
            $delayTime = $date  + ($interval * $mobileNumberCounter);
            // return date("Y-m-d H:i:s",$delayTime) ;
            $hour = (int)date("H", $delayTime) ;
            

            // if ( $hour >= 18 || $mobileNumberCounter >= $totalMessageCounter) {
            //     $date = strtotime('+16 hours', $delayTime);
            //     $delayTime = $date  + ($interval * $mobileNumberCounter);
            //     $mobileNumberCounter = 0;
            // }

            if ( $request->is_custom_sms==1 ){
                $mobilenumberAndContent = explode(';', $mobileNumberWith88Prefix);
                $mobileNumberWith88Prefix = $mobilenumberAndContent[0];
                $content = $mobilenumberAndContent[1];
            }

            $job = ( new SendSmsJob( $providerArray[$providerCounter], trim($mobileNumberWith88Prefix), $content, $campaign->id) )
                ->onQueue('campaign')
                // ->onQueue('default')
                ->delay( $delayTime- time());

            $this->dispatch($job);

            $providerCounter++;
            $mobileNumberCounter++;

            // \Queue::push( new SendSmsJob($providerArray[$providerCounter], $mobileNumberWith88Prefix, $content) );

        }

    }
}
