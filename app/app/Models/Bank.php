<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;

class Bank extends Model
{
    use SoftDeletes, Uuids, Searchable;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = [ 'name', 'identifier' ];

    protected $dates = ['deleted_at'];
}
