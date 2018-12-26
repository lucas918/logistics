<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user_info = \Session::get('user_info');

        // Step1：是否登录
        if (empty($user_info) || !isset($user_info['uid'])) {
            return redirect()->route('login');
        }

        // Step2：是否有操作权限

        return $next($request);
    }
}
