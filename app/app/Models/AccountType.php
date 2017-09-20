<?php

namespace App\Models;

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

    public function children()
    {
    	return $this->hasMany('App\Models\AccountType', 'parent_id');
    }

    public function scopeParent($query)
    {
    	return $query->where('parent_id', NULL);
    }
}