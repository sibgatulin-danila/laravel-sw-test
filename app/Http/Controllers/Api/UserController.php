<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Helpers\Auth;
use App\Helpers\Response;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController
{
    public function index()
    {
        $arUsers = Cache::remember(CacheType::UserIndex, Carbon::now()->addMinutes(3), function () {
            return User::all()->toArray();
        });
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

        Cache::forget(CacheType::UserIndex);

        return Response::success(['item' => $obUser], 201);
    }

    public function get(User $obUser) 
    {
        return Response::success([
            'item' => $obUser,
        ]);
    }

    public function delete(User $obUser)
    {
        $obUser->delete();
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

    public function login(Request $obRequest)
    {
        $obRequest->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $sEmail    = $obRequest->input('email');
        $sPassword = $obRequest->input('password');

        $obUser = User::where([
                ['email', '=', $sEmail],
            ])->first();
        
        if (!$obUser) return Response::error(404, 'Invalid credentials');
        if (!Hash::check($sPassword, $obUser->password)) {
            return Response::error(403, 'Login failed');
        }

        $sRefreshToken            = Auth::refreshToken($obUser);
        $sRememberToken           = Auth::rememberToken($obUser);
        $sRememberTokenExpireDate = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $obUser->remember_token             = $sRememberToken;
        $obUser->refresh_token              = $sRefreshToken;
        $obUser->remember_token_expire_date = $sRememberTokenExpireDate;
        $obUser->save();

        return Response::success([
            'token_type'          => 'bearer',
            'refresh_token'       => $sRefreshToken,
            'access_token'        => $sRememberToken,
            'access_token_expire' => $sRememberTokenExpireDate,
        ]);
    }

    public function refresh(Request $obRequest)
    {
        $obRequest->validate([
            'refresh_token' => 'required',
        ]);

        $sRefreshToken = $obRequest->input('refresh_token');

        $obUser = User::whereRefreshToken($obRequest->input('refresh_token'))->first();
        if (!$obUser) {
            return Response::error(404, 'User does not exist');
        }
        $obUser->remember_token             = Auth::refreshRememberToken($sRefreshToken);
        $obUser->remember_token_expire_date = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $obUser->save();

        return Response::success([
            'token_type'          => 'bearer',
            'access_token'        => $obUser->remember_token,
            'access_token_expire' => $obUser->remember_token_expire_date,
        ]);
    }
}
