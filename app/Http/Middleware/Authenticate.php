<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{

    protected function __construct($obRequest)
    {
        dd(explode(' ', $obRequest->header('Authorization')));
    }
}
