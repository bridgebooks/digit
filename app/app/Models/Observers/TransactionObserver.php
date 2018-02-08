<?php

namespace App\Models\Observers;


use App\Models\Transaction;

class TransactionObserver
{
    /**
     * @param Transaction $transaction
     */
    public function created(Transaction $transaction)
    {
        $transaction->account->updateYTD();
    }
}