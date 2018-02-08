<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use Uuids;

    public $table = "account_transactions";

    public $incrementing = false;

    protected $fillable = [
        'org_id',
        'source_id',
        'source_type',
        'account_id',
        'credit',
        'debit'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }
}
