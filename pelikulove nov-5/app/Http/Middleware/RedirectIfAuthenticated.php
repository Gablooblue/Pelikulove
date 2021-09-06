<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $previousUrl = url()->previous();

        if (!str_contains($previousUrl, 'login')) {       
            if (str_contains($previousUrl, 'watch') && str_contains($previousUrl, 'blackbox')) {
                $request->session()->put('redirectURL', $previousUrl);
                // dd($previousUrl, str_contains($previousUrl, 'login'), str_contains($previousUrl, 'watch'), str_contains($previousUrl, 'blackbox'));
            } else {
                $request->session()->forget('redirectURL');
            }
        } else {
            $request->session()->forget('redirectURL');
        }

        if (Auth::guard($guard)->check()) {
            return redirect()->intended('/home');
        }

        if (Auth::check()) {
            return redirect()->intended();
        }

        return $next($request);
    }
}
