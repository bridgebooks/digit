<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;

class Employee extends Model
{
    use SoftDeletes, Uuids, Searchable;
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

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User');
    }
}
