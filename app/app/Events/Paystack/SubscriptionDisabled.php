<?php

namespace App\Events\Paystack;

use Illuminate\Queue\SerializesModels;

class SubscriptionDisabled
{
    use SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}