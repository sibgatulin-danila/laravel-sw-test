<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;
use App\Models\Grade;

use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arGrades = Grade::get(); 

        return Response::success(['items' => $arGrades]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'grade'        => 'required',
            'school_id'    => 'required',
            'user_id_to'   => 'required',
            'user_id_from' => 'nullable',
            'class'        => 'nullable',
        ]);

        $obGrade = new Grade();
        $obGrade->fill($obRequest->all());
        $obGrade->save();

        return Response::success(['item' => $obGrade], 201);
    }

    public function get(Grade $obGrade) 
    {
        return Response::success(['item' => $obGrade]);
    }

    public function update(Request $obRequest, Grade $obGrade)
    {
        $obRequest->validate([
            'grade'        => 'required',
            'school_id'    => 'required',
            'user_id_to'   => 'required',
            'user_id_from' => 'nullable',
            'class'        => 'nullable',
        ]);

        $obGrade->fill($obRequest->all());
        $obGrade->save();

        return Response::success(['item' => $obGrade]);
    }

    public function delete(Grade $obGrade)
    {
        $obGrade->delete();
        return Response::success();
    }
}
