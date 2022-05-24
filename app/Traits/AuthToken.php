<?php

namespace App\Traits;

use App\Models\alumni\AccessToken;
use Illuminate\Support\Str;

trait AuthToken
{

    public function tokens()
    {
        return $this->morphMany(AccessToken::class, 'tokenable');
    }

    public function createToken(string $name, array $abilities = ['*'])
    {
        $info = (object)["name" => $this->name, "user_name" => $this->user_name, "reg_code" => $this->reg_code, "phone" => $this->phone, "email" => $this->email,"avatar" => $this->avatar];
        $info_json = base64_encode(json_encode($info));

        $plainTextToken =time().Str::random(20).uniqid(env("APP_NAME"),true);
        $send_token = base64_encode($plainTextToken.'$.$.$.$'.$info_json);

        $token = $this->tokens()->create([
            'name' => $name,
            'token' => $plainTextToken,
            'abilities' => $abilities,
        ]);

        return $send_token;
    }


}
