<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'debit_account_id',
        'credit_account_id',
        'credit',
        'debit'
    ];

    public function transactable()
    {
        return $this->morphTo();
    }
}
