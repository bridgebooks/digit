<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $table = "account_types";

    protected $guarded = [];

    protected $fillable = ['name', 'parent_id'];

    public function accounts()
    {
      return $this->hasMany('App\Models\Account');
    }
}