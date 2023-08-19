<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected $redirectRoute = [
        'admin' => 'admin.login',
        'web' => 'login'
    ];
    public function handle($request, Closure|\Closure $next, ...$guards)
    {
        if (empty($guards)) {
            $guards = ['web'];
        }

        foreach ($guards as $guard) {
            if (!$this->auth->guard($guard)->check()) {
                return redirect()->route($this->redirectRoute[$guard]);
            }
        }

        return $next($request);
    }
}
