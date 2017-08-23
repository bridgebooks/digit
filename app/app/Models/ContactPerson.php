<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;

class ContactPerson extends Model
{
    use SoftDeletes, Uuids, Searchable;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $table = "contact_people";

    protected $dates = ['deleted_at'];

    protected $fillable = [
      'contact_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'role',
        'is_primary_contact'
    ];

    public function contact()
    {
      return $this->belongsTo('App\Models\Contact');
    }
}
