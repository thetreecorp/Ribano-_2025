<?php

namespace App\Http\Middleware;

use App\Http\Traits\RedirectWithToken;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RedirectIfAuthenticated
{
    use RedirectWithToken;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check()){
            if($guard == 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                //return redirect()->route('user.home');
                // Check if there's a redirect_uri parameter
                $redirectUri = '';
                if ($request->has('redirect_uri') && $request->input('redirect_uri')) {
                    $redirectUri = $request->input('redirect_uri');
                    //Cache::put('redirect_uri', $redirectUri, now()->addMinutes(5));
                } 
                else if (Cache::has('redirect_uri')) {
                    $redirectUri = Cache::get('redirect_uri');
                    Cache::forget('redirect_uri');
                }

                if ($redirectUri) {
                    $redirect = $this->redirectWithToken($redirectUri);
                    if ($redirect) {
                        return $redirect;
                    }
                }
                
                // Default redirect for regular users if no redirect_uri
                return redirect()->route('user.home');
            }
        }

        return $next($request);
    }
}
