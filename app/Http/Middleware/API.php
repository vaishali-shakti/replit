<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;
use App\Models\Log;

class API
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('api')->check()) {
            return errorResponse('Unauthorised',null,401);
        } else{
            // check user login on another device
            $sessionId = $request->cookie('laravel_session');
            if (($sessionId && $sessionId !== Auth::guard('api')->user()->current_session_id) || Auth::guard('api')->user()->status != 1) {
                $user = Auth::guard('api')->user()->token();
                $user->revoke();
                return errorResponse('Unauthorised',null,402);
            }
        }

        return $next($request);

    }
}
