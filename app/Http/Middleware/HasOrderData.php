<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HasOrderData
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('order_data')) {
            return redirect()->route('reservations.personalization')
                ->with('error', 'Please configure your satchel first.');
        }
        
        return $next($request);
    }
}