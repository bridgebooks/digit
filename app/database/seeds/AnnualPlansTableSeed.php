<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;

class AnnualPlansTableSeed extends Seeder
{
    protected $plans = [
        [
            'name' => 'easy',
            'display_name' => 'Bridgebooks Easy (Annual)',
            'invoice_interval' => 'year',
            'invoice_period' => 1,
            'trial_interval' => 'day',
            'amount' => 22780,
            'description' => 'Bridgebooks starter plan for 1 year',
            'features' => [
                'users' => 0,
                'employees' => 10,
                'payruns' => 1,
                'invoices' => 10,
                'invoice_attachments' => 'false',
                'contacts' => 20,
                'activity_logs' => 'false'
            ]
        ],
        [
            'name' => 'pro',
            'display_name' => 'Bridgebooks Pro (Annual)',
            'invoice_interval' => 'year',
            'invoice_period' => 1,
            'trial_interval' => 'day',
            'amount' => 30000,
            'description' => 'Bridgebooks pro plan for 1 year',
            'features' => [
                'users' => 5,
                'employees' => -1,
                'payruns' => -1,
                'invoices' => -1,
                'invoice_attachments' => 'true',
                'contacts' => -1,
                'activity_logs' => 'true'
            ]
        ],
        [
            'name' => 'enterprise',
            'display_name' => 'Bridgebooks Enterprise (Annual)',
            'invoice_interval' => 'year',
            'invoice_period' => 1,
            'trial_interval' => 'day',
            'amount' => 36000,
            'description' => 'Bridgebooks enterprise plan for 1 year',
            'features' => [
                'users' => -1,
                'employees' => -1,
                'payruns' => -1,
                'invoices' => -1,
                'invoice_attachments' => 'true',
                'contacts' => -1,
                'activity_logs' => 'true'
            ]
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('plans')->truncate();

        foreach ($this->plans as $attributes) {
            $plan = new Plan();

            $plan->name = str_slug($attributes['name'],'-');
            $plan->display_name = $attributes['display_name'];
            $plan->invoice_interval = $attributes['invoice_interval'];
            $plan->invoice_period = $attributes['invoice_period'];
            $plan->trial_interval = $attributes['trial_interval'];
            $plan->trial_period = 30;
            $plan->amount = $attributes['amount'];
            $plan->description = $attributes['description'];
            $plan->status = 'active';

            if ($plan->save()) {
                $plan->createPaystackPlan('annually');
                $features = [];

                foreach($attributes['features'] as $feature => $value) {
                    $featureAttributes['name'] = $feature;
                    $featureAttributes['value'] = $value;

                    $features[] = $featureAttributes;

                    $plan->features()->createMany($features);
                }
            }
        }

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
