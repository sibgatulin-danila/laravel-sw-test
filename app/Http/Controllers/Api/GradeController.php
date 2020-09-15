<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\Grade;
use App\Models\School;

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
            'grade'      => 'required',
            'school_id'  => 'required',
            'user_id'    => 'required',
            'subject_id' => 'required',
            'class'      => 'nullable',
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
            'grade'      => 'nullable',
            'school_id'  => 'nullable',
            'user_id'    => 'nullable',
            'subject_id' => 'nullable',
            'class'      => 'nullable',
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

    // public function stat(Request $obRequest)
    // {
    //     $obRequest->validate([
    //         'school_id' => 'nullable',
    //         'class'     => 'nullable',
    //     ]);

    //     $nSchoolId = $obRequest->input('school_id', false);
    //     $nClass = $obRequest->input('class', false);

    //     $arStat = School::when($nSchoolId, function ($obQuery, $nSchoolId) {
    //             $obQuery->whereId($nSchoolId);
    //         })
    //         ->with([
    //             'school_classes' => function ($obQuery) use ($nClass) {
    //                 $obQuery->when($nClass, function ($obQuery, $nClass) {
    //                     $obQuery->whereClass($nClass);
    //                 });
    //             }
    //         ])
    //         ->get()
    //         ->map(function ($obItem) {
    //             foreach ($obItem->school_classes as &$obSchoolClass) {
    //                 $obSchoolClass->avarage_grade = $obSchoolClass->grades->avg('grade');
    //             }

    //             return $obItem;
    //         });

    //     return Response::success(['items' => $arStat]);
    // }
}
