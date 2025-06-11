<?php
// app/Http/Middleware/CustomerMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            return redirect('/')->with('error', 'Akses ditolak. Area khusus customer.');
        }

        return $next($request);
    }
}