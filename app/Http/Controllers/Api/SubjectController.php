<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheType;
use App\Helpers\Response;

use App\Http\Controllers\Controller;

use App\Http\Middleware\AuthorizationCheck;

use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(AuthorizationCheck::class);
    }

    public function index(Request $obRequest)
    {
        $obRequest->validate([
            'school_class_id' => 'required',
            'datetime' => 'nullable',
        ]);

        $nSchoolClassId = $obRequest->input('school_class_id', false);
        $sDateTime = $obRequest->input('datetime', false);

        $sParams = '';

        if ($nSchoolClassId) {
            $sParams .= $nSchoolClassId;
        }

        if ($sDateTime) {
            $sDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $sDateTime);
            $sParams .= $sDateTime;
        }

        $sParamHash = md5($sParams);

        $arSubjects = Cache::tags(CacheType::SubjectIndex)->remember($sParamHash, Carbon::now()->addMinutes(3), function () use ($nSchoolClassId, $sDateTime) {
            Cache::tags(CacheType::SubjectIndex)->flush();
            return Subject::when($nSchoolClassId, function ($obQuery, $nSchoolClassId) {
                    $obQuery->whereSchoolClassId($nSchoolClassId);
                })
                ->when($sDateTime, function ($obQuery, $sDateTime) {
                    $obQuery->where([
                        ['datetime', '>=', $sDateTime->copy()->startOfDay()],
                        ['datetime', '<=', $sDateTime->copy()->endOfDay()],
                    ]);
                })
                ->get();
        }); 

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

        Cache::tags(CacheType::SubjectIndex)->flush();
        
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
