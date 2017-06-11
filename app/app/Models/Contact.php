<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class Contact extends Model
{
    use SoftDeletes, Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function group()
    {
      return $this->belongsTo('App\Models\ContactGroup', 'contact_group_id');
    }

    public function contacts()
    {
      return $this->hasMany('App\Models\ContactPerson');
    }
}
