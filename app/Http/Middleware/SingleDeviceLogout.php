<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SingleDeviceLogout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('auth')->check()) {
            $sessionId = Session::get('current_session_id');
            // dd(($sessionId && $sessionId !== Auth::guard('auth')->user()->current_session_id), Auth::guard('auth')->user()->status == 0);
            if (($sessionId && $sessionId !== Auth::guard('auth')->user()->current_session_id) || Auth::guard('auth')->user()->status != 1) {
                Auth::guard('auth')->logout();
                Session::forget('current_session_id');
                return redirect()->route('front_login')->with('message', 'You have been logged out because your account was accessed from another device.');
            }
        }

        return $next($request);
    }
}
