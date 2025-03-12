<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackAdminActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $user = Auth::user();
            $user->is_online = true;
            $user->save();
        }

        return $next($request);
    }
}
