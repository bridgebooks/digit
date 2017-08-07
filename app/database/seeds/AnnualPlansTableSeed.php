<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;

class AnnualPlansTableSeed extends Seeder
{
    protected $plans = [
        [
            'name' => 'ZenBooks Easy annual',
            'interval' => 'annually',
            'amount' => 43200,
            'description' => 'ZenBooks starter plan for 365 day',
            'features' => [
            ]
        ],
        [
            'name' => 'ZenBooks Pro annual',
            'interval' => 'annually',
            'amount' => 72000,
            'description' => 'ZenBooks pro plan for 365 day',
            'features' => [
            ]
        ],
        [
            'name' => 'ZenBooks Enterprise annual',
            'interval' => 'annually',
            'amount' => 96000,
            'description' => 'ZenBooks enterprise plan for 365 day',
            'features' => [
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
        foreach ($this->plans as $attributes) {
            $plan = new Plan();

            $plan->name = str_slug($attributes['name'],'-');
            $plan->interval = $attributes['interval'];
            $plan->amount = $attributes['amount'];
            $plan->description = $attributes['description'];

            if ($plan->save()) {
                $plan->createPaystackPlan();
            }
        }
    }
}
