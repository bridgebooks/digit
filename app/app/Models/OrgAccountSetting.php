<?php

namespace App\Models;

use App\Models\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrgAccountSetting.
 *
 * @package namespace App\Models;
 */
class OrgAccountSetting extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'org_id',
        'values'
    ];

    public function setValuesAttribute($value)
    {
        $this->attributes['values'] = json_encode($value);
    }

    public function getValuesAttribute($value)
    {
        return json_decode($value);
    }

    public function org()
    {
        return $this->belongsTo('App\Models\Org');
    }

}
