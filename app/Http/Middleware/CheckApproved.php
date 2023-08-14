<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class CheckApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isApproved == false) {
            return redirect()->to('customer/approve');
        }
        return $next($request);
    }
}