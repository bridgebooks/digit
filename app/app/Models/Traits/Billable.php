<?php

namespace App\Models\Traits;

use App\Models\Libs\SubscriptionBuilder;
use App\Models\Plan;
use Carbon\Carbon;
use Mrfoh\Mulla\Api\Customers;
use Mrfoh\Mulla\Exceptions\EmptyDataException;
use Mrfoh\Mulla\Exceptions\InvalidFieldException;

trait Billable
{
    protected $paystackCustomers = null;

    private function getPaystackCustomersInstance() {
        if (is_null($this->paystackCustomers)) {
            $this->paystackCustomers = new Customers();
        }

        return $this->paystackCustomers;
    }

    public function hasCardOnFile()
    {
        return ! is_null($this->card_brand);
    }
    
    public function hasPaystackCustomerCode()
    {
        return ! is_null($this->paystack_customer_code);
    }

    public function createPaystackCustomer(array $metaData = [])
    {
        $customerData = [];

        try {
            $customerData['email'] = $this->email;

            if (!empty($metaData)) $customerData['metadata'] = $metaData;
            if ($this->first_name) $customerData['first_name'] = $this->first_name;
            if ($this->last_name) $customerData['first_name'] = $this->last_name;
            if ($this->phone) $customerData['phone'] = $this->phone;
            if ($this->email) $customerData['email'] = $this->email;

            $customer = $this->getPaystackCustomersInstance()->create($customerData);

            $this->paystack_customer_code = $customer['customer_code'];

            $this->save();
        } 
        catch (EmptyDataException $e) {
            return false;
        }
        catch (InvalidFieldException $e) {
            return false;
        }
    }

    public function asPaystackCustomer()
    {
        return $this->getPaystackCustomersInstance()->fetch($this->paystack_customer_code);
    }

    public function newSubscription(Plan $plan)
    {
        return new SubscriptionBuilder($this, $plan);
    }

    public function onTrial()
    {
        if (func_num_args() === 0 && $this->onGenericTrial()) {
            return true;
        }

        // TODO check user subscriptions for active trials
    }

    public function onGenericTrial()
    {
        return $this->trial_ends_at && Carbon::now()->lt($this->trial_ends_at);
    }

    public function onPlan()
    {
    }
}