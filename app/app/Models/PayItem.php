<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class PayItem extends Model
{
	use Uuids, SoftDeletes, Searchable;

	protected $table = 'pay_items';

	/**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'org_id',
        'user_id',
        'is_system',
        'name',
        'description',
        'account_id',
        'pay_item_type',
        'default_amount',
        'mark_default'
    ];

    public function account()
    {
        return $this->belongsTo('App\Models\Account');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function org()
    {
        return $this->belongsTo('App\Models\Org');
    }
}
