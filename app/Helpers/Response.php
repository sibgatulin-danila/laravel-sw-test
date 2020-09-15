<?php

namespace App\Helpers;

class Response 
{
    public static function success($arData = [], $nCode = 200)
    {
        return response(json_encode($arData), $nCode)
            ->header('Content-Type', 'application/json');
    }

    public static function error($nCode = 400, $sMessage = 'Unknown error')
    {
        return abort($nCode, $sMessage);
    }
}