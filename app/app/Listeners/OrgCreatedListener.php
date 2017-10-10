<?php

namespace App\Listeners;

use App\Models\OrgInvoiceSetting;
use App\Events\OrgCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use AccountsTableSeeder;
use TaxRatesTableSeeder;

class OrgCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrgCreated  $event
     * @return void
     */
    public function handle(OrgCreated $event)
    {
        $taxRatesSeeder = new TaxRatesTableSeeder($event->org);
        $accountsSeeder = new AccountsTableSeeder($event->org);

        // run seeders
        $taxRatesSeeder->run();
        $accountsSeeder->run();

        // create invoice settings
        $settings = new OrgInvoiceSetting(['org_id' => $event->org->id]);
    }
}
