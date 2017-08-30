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
        'email',
        'phone',
        'website',
        'address_line_1',
        'address_line_2',
        'city_town',
        'state_region',
        'postal_zip',
        'country',
        'bank_id',
        'bank_account_no',
        'bank_account_name'
    ];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function group()
    {
      return $this->belongsTo('App\Models\ContactGroup', 'contact_group_id');
    }

    public function people()
    {
      return $this->hasMany('App\Models\ContactPerson');
    }

    public function bank()
    {
        return $this->belongsTo('App\Models\Bank');
    }
}
