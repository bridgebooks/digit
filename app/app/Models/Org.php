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

    protected $fillable = [
        'name',
        'business_name',
        'business_reg_no',
        'logo_url',
        'description',
        'business_reg_no',
        'industry_id',
        'address_line_1',
        'address_line_2',
        'city_town',
        'country',
        'state_region',
        'postal_zip',
        'phone',
        'email',
        'website'
    ];

    public function industry()
    {
      return $this->belongsTo('App\Models\Industry');
    }

    public function users()
    {
      return $this->belongsToMany('App\Models\User', 'org_users');
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
