<?php

namespace App\Helpers;

use App\Models\User;

class Generator 
{
    public static function refreshToken($obUser)
    {
        return mb_substr(md5(mb_substr(md5(strval($obUser->id) . env('TOKEN_GENERATION_SALT') . $obUser->email), 3)), 2);
    }

    public static function accessToken($obUser)
    {
        return mb_substr(md5(mb_substr(md5(strval($obUser->id) . time()), 2) . $obUser->email), 3);
    }

    public static function refreshAccessToken($sRefreshToken)
    {
        $obUser = User::whereRefreshToken($sRefreshToken)->first();
        if ($obUser) {
            return self::accessToken($obUser);
        }
    }
}