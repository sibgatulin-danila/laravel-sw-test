<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AuthorizationCheck;
use App\Models\School;

use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arSchools = School::all()->toArray(); 

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
