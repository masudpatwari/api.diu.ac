<?php

namespace App\Models\alumni;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $guarded = [];
    protected $table = 'personal_access_tokens';

    public function tokenable()
    {
        return $this->morphTo();
    }

    public static function deleteToken($token)
    {
        $token = AccessToken::where('token', $token)->first();
        if ($token) {
            return $token->delete();
        } else {
            return false;
        }
    }

    public static function validToken($token)
    {
        try {

            $token_send = base64_decode($token);
            $token_found = explode("$.$.$.$", $token_send);
            $token_main = $token_found[0];
            $token_info = $token_found[1];
            $tokenInfo = self::with('tokenable')->where('token', $token_main);
            if ($tokenInfo->exists()) {
                $info = $tokenInfo->first();
                $expire = Carbon::parse($info->created_at)->diffInMinutes(Carbon::now());
                if ($expire >= config("app.api_expires")) {
                    return false;
                }
                return (object)['user' => $info->tokenable->select('name', 'user_name','reg_code','job_seeker','avatar')->first(), 'token' => $token];
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    protected $casts = [
        'abilities' => 'array',
    ];

}
