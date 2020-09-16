<?php

namespace App\Http\Controllers\Cron;

use App\Enums\UserType;
use App\Helpers\Response;
use App\Models\SchoolClass;
use App\Models\User;

class CronController
{
    public function index()
    {
        $arUsers = User::whereHas('school_class', function ($obQuery) {
                $obQuery->where('number', '<', 11);
            })
            ->whereRoleId(UserType::Student)->get();
        $arChangedClassesId = [];
        foreach ($arUsers as $obUser) {
            if (!isset($arChangedClassesId[$obUser->school_class->id])) {
                $obClass = SchoolClass::find($obUser->school_class->id);
                $arChangedClassesId[] = $obClass->id;
                $obClass->number = $obClass->number + 1;
                $obClass->save();
            }
        }
        return Response::success(['items' => $arUsers]);
    }
}
