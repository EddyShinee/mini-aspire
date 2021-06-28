<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (JWTException $e) {
                $token = $request->get('token', false);
                $user = JWTAuth::setToken($token)->authenticate();
            }

            Auth::login($user);
            return $next($request);
        } catch (TokenInvalidException $e) {
            return response(['status' => 401, 'msg' => 'Session was expired. Please login'], 200);
        } catch (JWTException $e) {
            return response(['status' => 401, 'msg' => 'Session was expired. Please login'], 200);
        } catch (TokenExpiredException $e) {
            return response(['status' => 401, 'msg' => 'Session was expired. Please login'], 200);
        }
    }
}
