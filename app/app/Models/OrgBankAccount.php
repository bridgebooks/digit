<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class OrgBankAccount extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, Uuids;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'org_bank_accounts';

    protected $fillable = ['bank_id', 'org_id', 'account_name', 'account_number', 'is_default', 'notes' ];

    protected $dates = ['deleted_at'];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function bank()
    {
      return $this->belongsTo('App\Models\Bank');
    }

    public function transform()
    {
    	return [
             'id' => $this->id,
             'org_id' => $this->org_id,
             'bank'   => [
             	'id' => $this->bank->id,
             	'name' => $this->bank->name,
             	'identifier' => $this->bank->identifier
             ]
             'account_name' => $this->account_name,
             'account_number' => $this->account_number,
             'created_at' => $this->created_at
         ];
    }

}
