<?php

namespace App\Traits;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;

trait DiuAcTraits
{
    public function cacheClear()
    {

        try {

            $url = env('DIU_SITE_URL') . '/cache-clear';
            $curl = Curl::to('https://diu.ac/cache-clear')->returnResponseObject();
            $curl->asJson(true);
            $response = $curl->get();
//            dump(\Log::error(print_r([$response->status, 'yes'], true)));
            return $response;

        } catch (\Exception $ex) {

            dump(\Log::error(print_r([$ex, 'yes'], true)));

        }


    }
}

?>
