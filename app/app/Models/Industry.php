<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Industry extends Model
{

    protected $guarded = [];

    public function orgs() {
      return $this->hasMany('App\Models\Org');
    }
}
