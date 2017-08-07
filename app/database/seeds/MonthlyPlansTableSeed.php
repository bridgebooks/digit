<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;

class MonthlyPlansTableSeed extends Seeder
{
    protected $plans = [
        [
            'name' => 'ZenBooks Easy Monthly',
            'interval' => 'monthly',
            'amount' => 3600,
            'description' => 'ZenBooks starter plan for 30 day',
            'features' => [
            ]
        ],
        [
            'name' => 'ZenBooks Pro Monthly',
            'interval' => 'monthly',
            'amount' => 6000,
            'description' => 'ZenBooks pro plan for 30 day',
            'features' => [
            ]
        ],
        [
            'name' => 'ZenBooks Enterprise Monthly',
            'interval' => 'monthly',
            'amount' => 8000,
            'description' => 'ZenBooks  plan for 30 day',
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
