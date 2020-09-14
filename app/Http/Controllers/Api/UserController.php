<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\User;

class UserController
{
    public function index()
    {
        $arUsers = User::all()->toArray(); 

        return Response::success(['users' => $arUsers])
            ->cookie('cookie', 'value', 3);
    }
}
