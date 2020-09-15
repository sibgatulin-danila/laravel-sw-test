<?php

namespace App\Helpers;

use App\Models\User;

class Auth 
{
    public static function refreshToken($obUser)
    {
        return mb_substr(md5(mb_substr(md5(strval($obUser->id) . env('TOKEN_GENERATION_SALT') . $obUser->email), 3)), 2);
    }

    public static function rememberToken($obUser)
    {
        return mb_substr(md5(mb_substr(md5(strval($obUser->id) . time()), 2) . $obUser->email), 3);
    }

    public static function refreshRememberToken($sRefreshToken)
    {
        $obUser = User::whereRefreshToken($sRefreshToken)->first();
        if ($obUser) {
            return self::rememberToken($obUser);
        }
    }

    public static function getUserByBearerToken($sBearerToken)
    {
        $arHeaderAuthorization = explode(' ', $sBearerToken);
        if (count($arHeaderAuthorization) == 2 && $arHeaderAuthorization[0] === 'Bearer') {
            return User::whereRememberToken($arHeaderAuthorization[1])->first();
        } 

        return false;
    }
}