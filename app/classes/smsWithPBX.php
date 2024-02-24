<?php

namespace App\classes;

use Ixudra\Curl\Facades\Curl;

class smsWithPBX
{
	public static $url = 'https://pbx.diu.ac/goip/';


    public static function send($provider, $mobileNumberWith88Prefix, $content)
    {
    	// \Log::error([$provider, $mobileNumberWith88Prefix, $content]);
    	// return;

    	$url = static::$url . "sendsms/";

    	$data = [
    		'auth' => ['username'=>'api1', 'password'=>'api1'],
    		'provider' => $provider,
    		'number' => $mobileNumberWith88Prefix,
    		'content' => $content
    	];
        
//         dd([$url,$data]);
//         \Log::error([$url,$data]);

        $response = Curl::to($url)
                ->withData($data)
                // ->returnResponseObject()
                ->asJson(true)
                ->post();


        return $response;
//        }catch (\Exception $exception)
//        {
//            return response($exception->getMessage());
//        }
    }

    public static function getQuery($provider, $taskID)
    {
    	$url = static::$url . "querysms/";

    	$data = [
    		'auth' => ['username'=>'api1', 'password'=>'api1'],
    		'taskID' => $taskID,
    	];

        $response = Curl::to($url)
            ->withData($data)
            // ->returnResponseObject()
            ->asJson(true)
            ->post();

            return $response;
    }
}
 
// https://pbx.diu.ac/goip/sendsms/

// json body (raw):

// {
// "auth":{"username":"api1","password":"api1"},
// "provider":"01302690346",
// "number":"8801703655691,8801521424060",
// "content":"01302690346 from provider"
// }


// https://pbx.diu.ac/goip/querysms/

// json body (raw):

// {
// "auth":{"username":"api1","password":"api1"},
// "taskID":"38"
// }