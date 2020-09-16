<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Enums\UserType;

use App\Helpers\Response;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeeController
{
    public function index()
    {
        $arUsers = Cache::remember(CacheType::EmployeeIndex, Carbon::now()->addMinutes(3), function () {
            return User::where([
                    ['role_id', '>', UserType::Student],
                    ['role_id', '<', UserType::Admin],
                ])
                ->get();
        }); 
        return Response::success(['items' => $arUsers]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'email'          => 'required|email|unique:users',
            'password'       => 'required',
            'name'           => 'nullable',
            'sex'            => 'nullable',
            'role_id'        => 'nullable',
            'birthday'       => 'nullable',
            'school_id'      => 'nullable',
            'hire_date'      => 'nullable',
            'dismissal_date' => 'nullable',
        ]);

        $obUser = new User();
        $obUser->fill($obRequest->all());

        if (!$obUser->role_id) {
            $obUser->role_id = UserType::Teacher;
        }
        if (!$obUser->hire_date) {
            $obUser->hire_date = date('Y-m-d H:i:s', time());
        }

        $obUser->save();

        Cache::forget(CacheType::EmployeeIndex);

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
            'password'  => 'nullable',
            'name'      => 'nullable',
            'sex'       => 'nullable',
            'role_id'   => 'nullable',
            'birthday'  => 'nullable',
            'school_id' => 'nullable',

            'dismissal_date' => 'nullable',
            'hire_date'      => 'nullable',
        ]);
        $obUser->fill($obRequest->all());
        $obUser->save();

        return Response::success(['item' => $obUser]);
    }
}
