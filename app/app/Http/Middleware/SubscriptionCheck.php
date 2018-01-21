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
        if ($this->userHasRole('org_admin') && $this->user->getActiveSubscription()) {
            return $next($request);
        } else if ($this->userHasRole('org_member') && $this->user->getOrgActiveSubscription()) {
            return $next($request);
        } else {
            \App::abort(402, 'No active subscription found. Please subscribe to a Bridgebooks plan');
        }
    }
}
