<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClienteAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('cliente_id')) {
            return redirect()->route('cliente.login');
        }
        return $next($request);
    }
}