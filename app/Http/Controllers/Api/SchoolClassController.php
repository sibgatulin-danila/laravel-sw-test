<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\SchoolClass;

use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arSchoolClasses = SchoolClass::all(); 

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
