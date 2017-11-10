<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\UserRequest;

class SubscriptionCheck
{
    use UserRequest;

    protected $user;

    public function __construct() 
    {
        $this->user = $this->requestUser();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
