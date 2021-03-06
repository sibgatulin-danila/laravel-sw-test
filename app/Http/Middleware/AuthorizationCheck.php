<?php

namespace App\Http\Middleware;

use App\Helpers\Auth;
use App\Helpers\Response;
use Closure;
use Illuminate\Http\Request;

class AuthorizationCheck
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
        if ($obUser) {
            if ($obUser->remember_token_expire_date > date('Y-m-d H:i:s', time())) {
                return $next($obRequest);
            } else {
                $obUser->remember_token = null;
                $obUser->save();

                return Response::error(403, 'Your access token has expired. To get new access token, make new request on path: "/user/refresh", with post parameter "refresh_token"');
            }
        }
        return Response::error(403, 'uthorization failed');
    }
}
