<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\SchoolClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arSchoolClasses = Cache::remember(CacheType::SchoolClassIndex , Carbon::now()->addMinutes(10), function () {
            return SchoolClass::all();
        }); 

        return Response::success(['items' => $arSchoolClasses]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'number'          => 'numeric',
            'symbol'          => 'nullable',
            'school_id'       => 'nullable',
        ]);

        $obSchoolClass = new SchoolClass();
        $obSchoolClass->fill($obRequest->all());
        $obSchoolClass->save();

        Cache::forget(CacheType::SchoolClassIndex);

        return Response::success(['item' => $obSchoolClass], 201);
    }

    public function get(SchoolClass $obSchoolClass) 
    {
        return Response::success(['item' => $obSchoolClass]);
    }

    public function update(Request $obRequest, SchoolClass $obSchoolClass)
    {
        $obRequest->validate([
            'number'    => 'nullable',
            'symbol'    => 'nullable',
            'school_id' => 'nullable',
        ]);

        $obSchoolClass->fill($obRequest->all());
        $obSchoolClass->save();

        return Response::success(['item' => $obSchoolClass]);
    }

    public function delete(SchoolClass $obSchoolClass)
    {
        $obSchoolClass->delete();
        return Response::success();
    }
}
