<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class ContactGroup extends Model
{
    use SoftDeletes, Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $table = "contact_groups";

    protected $fillable = ['org_id', 'name', 'description'];

    protected $dates = ['deleted_at'];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact', 'contact_group_id');
    }
}
