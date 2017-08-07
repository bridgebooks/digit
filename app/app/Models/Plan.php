<?php

namespace App\Models;

use Carbon\Carbon;
use Mrfoh\Mulla\Api\Plans;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Uuids;

class Plan extends Model
{
    use Uuids;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $guarded = [];

    protected $fillable = [ 'name', 'description', 'interval', 'amount', 'currency', 'status' ];

    protected $paystackPlans = null;

    private function getPaystackPlansInstance() {
        if(is_null($this->paystackPlans)) {
            $this->paystackPlans = new Plans();
        }

        return $this->paystackPlans;
    }

    public function features() 
    {
      return $this->hasMany('App\Models\PlanFeature');
    }

    public function createPaystackPlan()
    {
        $planAttributes = [];

        $planAttributes['name'] = $this->name;
        $planAttributes['interval'] = $this->interval;
        $planAttributes['amount'] = $this->amount * 100;
        $planAttributes['description'] = $this->description ? $this->description : '';
        $planAttributes['currency'] = $this->currency ? $this->currency : 'NGN';

        $paystackPlans = $this->getPaystackPlansInstance();

        $plan = $paystackPlans->create($planAttributes);

        if ($plan) {
            $this->paystack_plan_code = $plan['plan_code'];
            return $this->save();
        } else {
            return false;
        }
    }
}
