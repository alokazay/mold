<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Roles
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $params)
    {
        $success = false;
        $roles = explode('|', $params);
        foreach ($roles as $role_id) {
            if ($role_id == Auth::user()->group_id) {
                $success = true;
            }
        }
        if ($success) {
            return $next($request);
        } else {
            return redirect(url('/'));
        }

    }
}
