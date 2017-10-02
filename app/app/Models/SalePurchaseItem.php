<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Uuids;
use Laravel\Scout\Searchable;
use Prettus\Repository\Traits\TransformableTrait;

class SalePurchaseItem extends Model
{
    use SoftDeletes, Uuids, Searchable;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'sale_items';

    protected $fillable = [
    	'org_id',
    	'user_id',
    	'code',
    	'name',
    	'is_sold',
    	'is_purchased',
    	'sale_description',
    	'purchase_description',
    	'sale_unit_price',
    	'sale_account_id',
    	'sale_tax_id',
    	'purchase_unit_price',
    	'purchase_account_id',
    	'purchase_tax_id',
    ];

    protected $dates = ['deleted_at'];

    public function org()
    {
      return $this->belongsTo('App\Models\Org');
    }

    public function saleAccount()
    {
    	return $this->belongsTo('App\Models\Account', 'sale_account_id');
    }

    public function saleTaxRate()
    {
    	return $this->belongsTo('App\Models\TaxRate', 'sale_tax_id');
    }

    public function purchaseAccount()
    {
    	return $this->belongsTo('App\Models\Account', 'purchase_account_id');
    }

    public function purchaseTaxRate()
    {
    	return $this->belongsTo('App\Models\TaxRate', 'purchase_tax_id');
    }
}
