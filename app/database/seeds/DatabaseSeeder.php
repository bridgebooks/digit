<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(IndustriesTableSeeder::class);
        $this->call(MonthlyPlansTableSeed::class);
        $this->call(AnnualPlansTableSeed::class);
        $this->call(BanksTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AccountTypesTableSeeder::class);
        $this->call(AccountTypeChildSeeder::class);
    }
}
