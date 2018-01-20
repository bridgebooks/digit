<?php

namespace App\Http\Controllers\V1\Payments;

use App\Events\SubscriptionPaymentSuccess;
use App\Http\Controllers\V1\Controller;
use Illuminate\Http\Request;
use Mrfoh\Mulla\Api\Transaction as PaystackTransaction;

class PaystackCallbackController extends Controller
{
    protected $paystackTransaction;

    public function __construct()
    {
        $this->paystackTransaction = new PaystackTransaction();
    }

    public function handle(Request $request)
    {
        $transactionReference = $request->input('reference');

        $verify = $this->paystackTransaction->verify($transactionReference);

        if ($verify['status'] == "success") {
            $authorization = $verify['authorization'];
            $plan = $verify['plan'];
            $email = $verify['customer']['email'];

            $url = config('app.frontend_url').'/billing/subscription';

            event(new SubscriptionPaymentSuccess($email, $authorization, $plan));

            return redirect()->to($url);
        }
    }
}