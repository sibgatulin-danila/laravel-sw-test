<?php

namespace App\Helpers;

class Response 
{
    public static function success($arData = [])
    {
        return response()->json($arData)
            ->header('Content-Type', 'application/json');
    }

    public static function error($nCode = 400, $sMessage = 'Unknown error')
    {
        return abort($nCode, $sMessage);
    }
}