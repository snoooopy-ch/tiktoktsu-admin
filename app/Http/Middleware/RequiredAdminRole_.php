<?php

namespace App\Http\Middleware;

use Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class RequiredAdminRole_ extends Middleware
{

    protected $except = [
    ];
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            return route('news.view');
        } else {
            return $next($request);
        }
    }
}
