<?php

namespace App\Http\Middleware;

use App\Enums\UserType;

use App\Helpers\Auth;
use App\Helpers\Response;

use Closure;

use Illuminate\Http\Request;

class HeadTeacherCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $obRequest, Closure $next)
    {
        $sHeaderAuthorization = $obRequest->header('Authorization');
        if (!$sHeaderAuthorization) return Response::error(403, 'bad authorization token');
        $obUser = Auth::getUserByBearerToken($sHeaderAuthorization);
        if ($obUser && $obUser->role_id >= UserType::HeadTeacher) {
            return $next($obRequest);
        }
        return Response::error(401, 'uthorization failed');
    }
}
