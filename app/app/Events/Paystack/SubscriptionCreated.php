<?php

namespace App\Events\Paystack;

use Illuminate\Queue\SerializesModels;

class SubscriptionCreated
{
    use SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}