<?php

namespace App\Http\Middleware;

use App\Libraries\AuthManager;
use App\Libraries\UserHelper;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    protected $except = [
        'user*',
        'call/invite/*'
    ];

    protected function isInException($request) {
        $is = false;

        foreach($this->except as $e) {
            if ( $request->is($e) ) {
                $is = true;
            }
        }

        return $is;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        $user = AuthManager::getAuthUser($request);

        if ( !$user && !$this->isInException($request) ) {
            return redirect(route('login'));
        }

        return $next($request);
    }
}
