<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\School;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arSchools = Cache::remember(CacheType::SchoolIndex, Carbon::now()->addMinutes(10), function () {
            return School::all(); 
        });
        return Response::success(['items' => $arSchools]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'name'            => 'required',
            'address'         => 'nullable',
            'foundation_date' => 'nullable',
            'closing_date'    => 'nullable',
        ]);

        $obSchool = new School();
        $obSchool->fill($obRequest->all());
        $obSchool->save();

        Cache::forgot(CacheType::SchoolIndex);

        return Response::success(['item' => $obSchool], 201);
    }

    public function get(School $obSchool) 
    {
        return Response::success(['item' => $obSchool]);
    }

    public function update(Request $obRequest, School $obSchool)
    {
        $obRequest->validate([
            'name'            => 'nullable',
            'address'         => 'nullable',
            'foundation_date' => 'nullable',
            'closing_date'    => 'nullable',
        ]);

        $obSchool->fill($obRequest->all());
        $obSchool->save();

        return Response::success(['item' => $obSchool]);
    }

    public function delete(School $obSchool)
    {
        $obSchool->delete();
        return Response::success();
    }
}
