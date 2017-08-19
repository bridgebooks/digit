<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;

class Contact extends Model
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

    protected $fillable = [
        'org_id',
        'user_id',
        'contact_group_id',
        'type',
        'name',
        'phone',
        'website',
        'address_line_1',
        'address_line_2',
        'city_town',
        'state_region',
        'postal_zip',
        'country',
    ];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function group()
    {
      return $this->belongsTo('App\Models\ContactGroup', 'contact_group_id');
    }

    public function contactPeople()
    {
      return $this->hasMany('App\Models\ContactPerson');
    }
}
