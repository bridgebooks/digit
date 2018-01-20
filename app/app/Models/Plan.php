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

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'invoice_interval',
        'invoice_period',
        'trial_period',
        'trial_interval',
        'amount',
        'currency',
        'status'
    ];

    protected $paystackPlans = null;

    private function getPaystackPlansInstance() {
        if(is_null($this->paystackPlans)) {
            $this->paystackPlans = new Plans();
        }

        return $this->paystackPlans;
    }

    /**
     * @param string $interval
     * @return string
     */
    private function setPaystackPlanInterval(string $interval)
    {
        $allowed = ['month', 'year', 'hour', 'week'];

        return in_array($interval, $allowed) ? $interval.'ly' : 'monthly';
    }

    public function features() 
    {
      return $this->hasMany('App\Models\PlanFeature');
    }

    public function createPaystackPlan()
    {
        $planAttributes = [];

        $planAttributes['name'] = $this->name;
        $planAttributes['interval'] = $this->setPaystackPlanInterval($this->invoice_interval);
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
