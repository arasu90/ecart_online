<?php

namespace App\Http\Middleware;

use App\CommonFunction;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddDefaultParameter
{
    use CommonFunction;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->merge(['cart_count' => $this->getCartCount()]);

        return $next($request);
    }
}
