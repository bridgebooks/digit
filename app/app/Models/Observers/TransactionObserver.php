<?php

namespace App\Models\Observers;


use App\Events\TransactionCreated;
use App\Models\Transaction;

class TransactionObserver
{
    /**
     * @param Transaction $transaction
     */
    public function created(Transaction $transaction)
    {
        event(new TransactionCreated($transaction->account));
    }
}