<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\Timetable;

use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index()
    {
        $arTimetables = Timetable::get(); 

        return Response::success(['items' => $arTimetables]);
    }

    public function create(Request $obRequest)
    {
        $obRequest->validate([
            'subject'         => 'required',
            'school_class_id' => 'required',
            'datetime'        => 'nullable',
        ]);

        $obTimetable = new Timetable();
        $obTimetable->fill($obRequest->all());
        $obTimetable->save();

        return Response::success(['item' => $obTimetable], 201);
    }

    public function get(Timetable $obTimetable) 
    {
        return Response::success(['item' => $obTimetable]);
    }

    public function update(Request $obRequest, Timetable $obTimetable)
    {
        $obRequest->validate([
            'subject'         => 'required',
            'school_class_id' => 'required',
            'datetime'        => 'nullable',
        ]);

        $obTimetable->fill($obRequest->all());
        $obTimetable->save();

        return Response::success(['item' => $obTimetable]);
    }

    public function delete(Timetable $obTimetable)
    {
        $obTimetable->delete();
        return Response::success();
    }
}
