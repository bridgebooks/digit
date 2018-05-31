<?php

namespace App\Http\Controllers\V1\Users;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreateUserSubscription;
use App\Models\Plan;
use App\Models\User;
use App\Repositories\PlanRepository;
use App\Repositories\SubscriptionRepository;
use App\Traits\UserRequest;
use Mrfoh\Mulla\Api\Transaction as PaystackTransaction;
use Mrfoh\Mulla\Exceptions\InvalidRequestException;
use Mrfoh\Mulla\Exceptions\InvalidResponseException;

class UserBillingController extends Controller
{
    use UserRequest;

    protected $repository;

    protected $paystackTransaction;

    public function __construct(SubscriptionRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->repository = $repository;
        $this->paystackTransaction = new PaystackTransaction();
    }

    private function buildPaystackTransactionPayload(User $user, Plan $plan)
    {
        return [
           'callback_url' => config('app.paystack_callback_url'),
           'amount' => $plan->amount,
           'email' => $user->email,
           'plan' => $plan->paystack_plan_code
        ];
    }

    public function active()
    {
        $user = $this->requestUser();

        $subscription =  $this->repository->active($user);

        return (!is_null($subscription)) ? $subscription : response()->json(["status" => "error", "message" => "No subscription found" ], 404);
    }

    public function subscription(CreateUserSubscription $request, PlanRepository $plans)
    {
        $user = $this->requestUser();

        $plan = $plans->skipPresenter()->byName($request->input('plan'));

        if (!$user->hasCardOnFile()) {
            $payload = $this->buildPaystackTransactionPayload($user, $plan);

            try {
                $transaction = $this->paystackTransaction->initialize($payload);

                $data = [
                    'authorization_url' => $transaction['authorization_url'],
                    'reference' => $transaction['reference'],
                    'access_code' => $transaction['access_code']
                ];

                return response()->json([ 'data' => $data ], 200);
            } catch (InvalidRequestException $e) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Payment request malformed'
                ], 400);
            }
        } else {

            try {
                $user->newSubscription($plan)
                    ->skipTrial()
                    ->create(['skip_paystack' => false]);

                return $this->repository->active($user);
            } catch (InvalidRequestException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 400);
            } catch (InvalidResponseException $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ], 400);
            }
        }
    }

    /**
     * Cancel user's active subscription
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancel()
    {
        $user = $this->requestUser();

        $subscription = $user->getActiveSubscription();

        if ($subscription) {

            if ($subscription->cancel(false)->disablePaystackSubscription()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Your subscription has successfully been canceled.'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unable to cancel subscription.'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'No active subscription found.'
            ], 404);
        }
    }
}