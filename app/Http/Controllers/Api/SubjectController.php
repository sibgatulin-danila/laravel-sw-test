<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\Subject;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arSubjects = Subject::get(); 

        return Response::success(['items' => $arSubjects]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'name'            => 'required',
            'school_class_id' => 'required',
            'user_id'         => 'nullable',
            'datetime'        => 'nullable',
        ]);

        $obSubject = new Subject();
        $obSubject->fill($obRequest->all());
        $obSubject->save();

        return Response::success(['item' => $obSubject], 201);
    }

    public function get(Subject $obSubject) 
    {
        return Response::success(['item' => $obSubject]);
    }

    public function update(Request $obRequest, Subject $obSubject)
    {
        $obRequest->validate([
            'name'            => 'nullable',
            'school_class_id' => 'nullable',
            'user_id'         => 'nullable',
            'datetime'        => 'nullable',
        ]);

        $obSubject->fill($obRequest->all());
        $obSubject->save();

        return Response::success(['item' => $obSubject]);
    }

    public function delete(Subject $obSubject)
    {
        $obSubject->delete();
        return Response::success();
    }
}
