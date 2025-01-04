<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Check
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    protected $routeMiddleware = [
        // Other middleware...
        'Check' => \App\Http\Middleware\Check::class,
    ];
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if(Auth::check() && in_array(Auth::user()->role, $roles)){
            return $next($request);
        }
        abort(403);
    }
}
