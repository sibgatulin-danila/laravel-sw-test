<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function index()
    {
        $arUsers = User::all()->toArray(); 

        return Response::success(['items' => $arUsers]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'name'     => 'nullable',
            'sex'      => 'nullable',
            'role_id'  => 'nullable',
            'birthday' => 'nullable',
        ]);

        $obUser = new User();
        $obUser->fill($obRequest->all());
        $obUser->save();

        return Response::success(['item' => $obUser], 201);
    }

    public function get(User $obUser) 
    {
        return Response::success([
            'item' => $obUser,
        ]);
    }

    public function delete(Request $obRequest)
    {
        $obRequest->validate([
            'id' => 'required',
        ]);

        $nUserId = $obRequest->input('id');

        User::whereId($nUserId)->delete();

        Response::success();
    }

    public function update(Request $obRequest, User $obUser)
    {
        $obRequest->validate([
            'password' => 'nullable',
            'name'     => 'nullable',
            'sex'      => 'nullable',
            'role_id'  => 'nullable',
            'birthday' => 'nullable',
        ]);
        $obUser->fill($obRequest->all());
        $obUser->save();

        return Response::success(['item' => $obUser]);
    }

    // public function login(Request $obRequest)
    // {
    //     $obRequest->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $arCredentials = $obRequest->only(['email', 'password']);


    // }
}