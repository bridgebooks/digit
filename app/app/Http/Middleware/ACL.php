<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\UserRequest;

class ACL
{
    use UserRequest;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($this->can($role)) {
            return $next($request);
        } else {
            \App::abort(403, 'Access denied insufficient permissions');
        }
    }
}
