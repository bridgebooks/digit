<?php

namespace App\Models\Traits;

use Mrfoh\Mulla\Api\Customers;
use Mrfoh\Mulla\Exceptions\EmptyDataException;
use Mrfoh\Mulla\Exceptions\InvalidFieldException;

trait Billable
{
    protected $paystackCustomers = null;

    private function getPaystackCustomersInstance() {
        if(is_null($this->paystackCustomers)) {
            $this->paystackCustomers = new Customers();
        }

        return $this->paystackCustomers;
    }

    public function hasCardOnFile()
    {
        return (bool) $this->card_brand;
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

            if(!empty($metaData)) $customerData['metadata'] = $metaData;
            if($this->first_name) $customerData['first_name'] = $this->first_name;
            if($this->last_name) $customerData['first_name'] = $this->last_name;
            if($this->phone) $customerData['phone'] = $this->phone;

            $customer = $this->getPaystackCustomersInstance()->create($customerData);

            $this->paystack_customer_code = $customer['customer_code'];

            $this->save();
        } 
        catch(EmptyDataException $e) {
            return false;
        }
        catch(InvalidFieldException $e) {
            return false;
        }
    }

    public function asPaystackCustomer()
    {
        return $this->getPaystackCustomersInstance()->fetch($this->paystack_customer_code);
    }
}