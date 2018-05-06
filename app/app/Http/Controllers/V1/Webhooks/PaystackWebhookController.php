<?php

namespace App\Http\Controllers\V1\Webhooks;


use App\Events\Paystack\SubscriptionCreated;
use App\Events\Paystack\SubscriptionDisabled;
use App\Events\Paystack\SubscriptionEnabled;
use App\Http\Controllers\V1\Controller;
use Illuminate\Http\Request;

class PaystackWebhookController extends Controller
{
    private $paystackSecret;

    public function __construct()
    {
        $this->paystackSecret = env('PAYSTACK_SECRET_KEY');
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function validateSignature(Request $request)
    {
        $header = $request->hasHeader('HTTP_X_PAYSTACK_SIGNATURE')
            ? $request->header('HTTP_X_PAYSTACK_SIGNATURE')
            : $request->header('x-paystack-signature');

        $input = json_encode($request->all());
        $signature = hash_hmac('sha512', $input, $this->paystackSecret);

        return $header === $signature;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function process(Request $request)
    {
        if (!$this->validateSignature($request))  {
            return response()->json([], 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        switch ($event) {
            case 'subscription.create':
                event(new SubscriptionCreated($data));
                break;

            case 'subscription.enable':
                event(new SubscriptionEnabled($data));
                break;

            case 'subscription.disable':
                event(new SubscriptionDisabled($data));
                break;

            case 'invoice.update':
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }
}