<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::user()){
            return redirect()->route('admin.login')->with('login_error', 'Your Session has expired');
        }

        if(Auth::user()?->user_type == 'admin'){
            return $next($request);
        }else{
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            
            return redirect()->route('admin.login')->with('login_error', 'You do not have permission to access this page !');
        }
    }
}
