<?php

namespace App\Traits;

use Ixudra\Curl\Facades\Curl;

trait Microsoft
{
    public function token()
    {
        try {

            $guzzle = new \GuzzleHttp\Client();
            $tenantId = env('MICROSOFT_TENANT_ID');
            $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token?api-version=1.0';
            $token = json_decode($guzzle->post($url, [
                'form_params' => [
                    'client_id' => env('MICROSOFT_CLIENT_ID'),
                    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                    'resource' => 'https://graph.microsoft.com/',
                    'grant_type' => 'client_credentials',
                ],
            ])->getBody()->getContents());

            $accessToken = $token->access_token;
            return $accessToken;

        } catch (\Exception $e) {

            \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            return response()->json(['msg' => 'Token not found'], 401);

        }
    }
}

?>
