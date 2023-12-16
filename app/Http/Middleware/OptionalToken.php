<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OptionalToken
{
    public function handle(Request $request, Closure $next)
    {
        // You can add additional logic here if needed.
        // For now, we're just allowing the request to proceed.

        return $next($request);
    }
}

