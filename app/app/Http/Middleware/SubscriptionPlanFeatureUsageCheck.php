<?php

namespace App\Http\Middleware;

use App\Events\FeatureUsed;
use App\Models\Subscription;
use App\Traits\UserRequest;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionPlanFeatureUsageCheck
{
    use UserRequest;

    private $user;
    private $subscription;

    public function __construct()
    {
        $this->user = $this->requestUser();
        $this->subscription = $this->getSubscription();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $featureName)
    {
        $request->attributes->add(["feature" => $featureName]);

        if ($this->subscription->canUseFeature($featureName))
            return $next($request);
        else
            \App::abort(426, 'Your current plan does not support this feature. Please upgrade.');
    }

    /**
     * Handle completed request
     * @param $request
     * @param JsonResponse $response
     */
    public function terminate(Request $request, JsonResponse $response)
    {
        $featureName = $request->attributes->get('feature');
       $recordableFeatures = ['employees', 'payruns', 'invoices', 'contacts', 'users'];
       $shouldRecordFeatureUsage = in_array($featureName, $recordableFeatures);

       if ($response->status() === 200 && $shouldRecordFeatureUsage) {
           event(new FeatureUsed($featureName, $this->subscription));
       }

    }
}
