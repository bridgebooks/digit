<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\Role;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MigrateSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate subscriptions to live mode';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function clearUserPaystackData() {

        User::query()
            ->whereNotNull('paystack_customer_code')
            ->whereNotNull('authorization_code')
            ->update([
               'paystack_customer_code' => null,
               'authorization_code' => null,
               'card_brand' => null,
               'card_last_four' => null,
               'card_exp_month' => null,
                'card_exp_year' => null
            ]);
    }

    private function truncateSubscriptions() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subscriptions')->truncate();
        DB::table('subscription_usages')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    private function seedPlans() {
        $seeder = new \MonthlyPlansTableSeed();
        $seeder->run();
    }


    private function getUsers() {
        return User::whereHas('roles', function ($q) {
            $q->where('name', 'org_admin');
        })->get();
    }

    private function createPaystackCustomers() {
        $users = $this->getUsers();

        $users->each(function ($user) {
           $user->createPaystackCustomer();
        });
    }

    private function createSubscriptions() {
        $users = $this->getUsers();
        $plan = Plan::where('name', 'pro')->first();

        $users->each(function ($user) use ($plan) {
           $user->newSubscription($plan)->create([ 'skip_paystack' => true ]);
        });
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Clearing paystack data');
        // Clear user paystack data
        $this->clearUserPaystackData();

        $this->info('Truncate subscriptions');
        // Truncate subscription and subscription usages
        $this->truncateSubscriptions();

        $this->info('Seeding new plans');
        // Seed plans in production
        $this->seedPlans();

        $this->info('Creating paystack customers');
        // Create paystack customers for each primary user
        $this->createPaystackCustomers();

        $this->info('Create new subscriptions');
        // Create trial subscription for each user pro plan
        $this->createSubscriptions();
    }
}
