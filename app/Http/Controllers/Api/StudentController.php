<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Enums\UserType;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\HeadTeacherCheck;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware(HeadTeacherCheck::class);
    }

    public function index()
    {
        $arUsers = Cache::remember(CacheType::StudentIndex, Carbon::now()->addMinutes(10), function () {
            return User::whereHas('school_classes', function ($obQuery) {
                    $obQuery->where('number', '<=', 11);
                })
                ->whereRoleId(UserType::Student)
                ->get();  
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
            'birthday' => 'nullable',

            'school_class_id' => 'nullable',
            'enrollment_date' => 'nullable',
        ]);

        $obUser = new User();
        $obUser->fill($obRequest->all());
        $obUser->role_id = UserType::Student;

        if (!$obUser->enrollment_date) {
            $obUser->enrollment_date = date('Y-m-d H:i:s', time());
        }

        $obUser->save();

        Cache::forgot(CacheType::StudentIndex);

        return Response::success(['item' => $obUser], 201);
    }

    public function get(User $obUser) 
    {
        return Response::success(['item' => $obUser]);
    }

    public function update(Request $obRequest, User $obUser)
    {
        $obRequest->validate([
            'password' => 'nullable',
            'name'     => 'nullable',
            'sex'      => 'nullable',
            'birthday' => 'nullable',

            'school_id'       => 'nullable',
            'class'           => 'nullable',
            'class_symbol'    => 'nullable',
            'enrollment_date' => 'nullable',
        ]);

        $obUser->fill($obRequest->only([
            'password',
            'name',
            'sex',
            'birthday',
            'school_id',
            'class',
            'class_symbol',
            'enrollment_date',
        ]));
        $obUser->save();

        return Response::success(['item' => $obUser]);
    }

    public function delete(User $obUser)
    {
        $obUser->delete();
        return Response::success();
    }
}
