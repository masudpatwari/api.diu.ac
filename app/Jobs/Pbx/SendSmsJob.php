<?php 

namespace App\Jobs\Pbx;

use App\classes\smsWithPBX;
use App\Jobs\Job;
use App\Models\PBX\SmsSendResponse;

class SendSmsJob extends Job
// implements ShouldQueue
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $provider;
    protected $mobileNumberWith88Prefix;
    protected $content;
    protected $pbx_campaign_id;
    /**
     * Create a new job instance.
     *
     * @param  App\Models\Podcast  $podcast
     * @return void
     */
    public function __construct( $provider, $mobileNumberWith88Prefix, $content, $pbx_campaign_id)
    {
        $this->provider = $provider;
        $this->mobileNumberWith88Prefix = $mobileNumberWith88Prefix;
        $this->content = $content;
        $this->pbx_campaign_id = $pbx_campaign_id;
    }

    /**
     * Execute the job.
     *
     * @param  App\Services\AudioProcessor  $processor
     * @return void
     */
    public function handle()
    {

    	// pbx_campaign_id($this->pbx_campaign_id);

//    	\Log::alert('provider='.$this->provider .', to-'. $this->mobileNumberWith88Prefix . ', msg-' . $this->content .
//            ' pbx_campaign_id-'. $this->pbx_campaign_id);

         $response = smsWithPBX::send($this->provider , $this->mobileNumberWith88Prefix , $this->content);

        if( isset($response['result']) && ($response['result'] == 'ACCEPT' || $response['result'] == 'REJECT') ){


            $presentTime  = time();

            $smsSendResponse = new SmsSendResponse;
            $smsSendResponse->pbx_campaign_id =  $this->pbx_campaign_id;
            $smsSendResponse->mobilenumber =  $this->mobileNumberWith88Prefix;
            $smsSendResponse->response =  json_encode($response);
            $smsSendResponse->result = $response['result'];
            $smsSendResponse->taskId = $response['taskID']??null;
            $smsSendResponse->reason = $response['reason']??null;
            $smsSendResponse->reason = $response['reason']??null;
            $smsSendResponse->reason = $response['reason']??null;
            $smsSendResponse->created_at = $presentTime;
            $smsSendResponse->updated_at = $presentTime;

            $smsSendResponse->save();   
        }else{
//            \Log
            \Log::alert('PBX send message fail!');

//        	throw \Exeption('PBX send message fail!');
        }

    }
}