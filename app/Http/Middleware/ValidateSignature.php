<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Illuminate\Http\Request;

class ValidateSignature extends Middleware
{
    protected $except = [
        '/storage/*',
    ];

    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
