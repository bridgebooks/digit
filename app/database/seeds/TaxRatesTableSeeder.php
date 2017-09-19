<?php

use Illuminate\Database\Seeder;
use App\Models\TaxRate;
use App\Models\TaxRateComponent;
use App\Models\Org;

class TaxRatesTableSeeder extends Seeder
{
    protected $org;

    public function __construct(Org $org)
    {
        $this->org = $org;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vatTax = new TaxRate();

        $vatTax->name = 'Value Added Tax';
        $vatTax->org_id = $this->org->id;
        $vatTax->is_system = false;

        $vatTax->save();

        $vatComponent = new TaxRateComponent();
        $vatComponent->tax_rate_id = $vatTax->id;
        $vatComponent->name = "VAT";
        $vatComponent->value = 5;
        $vatComponent->compound = false;
        $vatComponent->save();

        $tax = new TaxRate();

        $tax->name = 'Tax Exempt';
        $tax->org_id = $this->org->id;
        $tax->is_system = false;

        $tax->save();

        $component = new TaxRateComponent();
        $component->tax_rate_id = $tax->id;
        $component->name = "Tax Exempt";
        $component->value = 0;
        $component->compound = false;
        $component->save();
    }
}
