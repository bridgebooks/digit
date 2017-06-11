<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Org extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    public function industry()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function users()
    {
      return $this->belongsToMany('App\Models\Users', 'org_users');
    }

    public function employees()
    {
      return $this->hasMany('App\Models\Employee', 'org_id');
    }

    public function contacts()
    {
      return $this->hasMany('App\Models\Contact');
    }
}
