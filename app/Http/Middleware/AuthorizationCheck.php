<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use App\Models\User;
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
        $arHeaderAuthorization = explode(' ', $sHeaderAuthorization);
        if (count($arHeaderAuthorization) == 2 && $arHeaderAuthorization[0] === 'Bearer') {
            $obUser = User::whereRememberToken($arHeaderAuthorization[1])->first();
            if ($obUser) {
                return $next($obRequest);
            }
        }
    }
}
