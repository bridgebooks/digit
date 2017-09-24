<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;

class OrgBankAccount extends Model
{
    use SoftDeletes, Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'org_bank_accounts';

    protected $fillable = [ 'name', 'bank_id', 'org_id', 'user_id', 'account_name', 'account_number', 'is_default', 'notes' ];

    protected $dates = ['deleted_at'];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function bank()
    {
      return $this->belongsTo('App\Models\Bank');
    }
}
