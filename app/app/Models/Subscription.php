<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Subscription extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    public function owner()
    {
      return $this->belongsTo('App\Models\User');
    }

    public function plan()
    {
      return $this->belongsTo('App\Models\Plan');
    }
}
