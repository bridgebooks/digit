<?php

use Illuminate\Database\Seeder;
use App\Models\Bank;

class BanksTableSeeder extends Seeder
{
    protected $json = '{
    "data": {
        "214": "FIRST CITY MONUMENT BANK PLC",
        "215": "UNITY BANK PLC",
        "221": "STANBIC IBTC BANK PLC",
        "232": "STERLING BANK PLC",
        "301": "JAIZ BANK",
        "304": "Stanbic Mobile",
        "305": "PAYCOM",
        "307": "Ecobank Mobile",
        "309": "FBN MOBILE",
        "311": "Parkway",
        "315": "GTBank Mobile Money",
        "322": "ZENITH Mobile",
        "323": "ACCESS MOBILE",
        "401": "Aso Savings and Loans",
        "044": "ACCESS BANK NIGERIA",
        "014": "AFRIBANK NIGERIA PLC",
        "063": "DIAMOND BANK PLC",
        "050": "ECOBANK NIGERIA PLC",
        "084": "ENTERPRISE BANK LIMITED",
        "070": "FIDELITY BANK PLC",
        "011": "FIRST BANK PLC",
        "058": "GTBANK PLC",
        "030": "HERITAGE BANK",
        "082": "KEYSTONE BANK PLC",
        "076": "SKYE BANK PLC",
        "068": "STANDARD CHARTERED BANK NIGERIA LIMITED",
        "032": "UNION BANK OF NIGERIA PLC",
        "033": "UNITED BANK FOR AFRICA PLC",
        "035": "WEMA BANK PLC",
        "057": "ZENITH BANK PLC"
    }
    }';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = json_decode($this->json, true);

        foreach ($banks['data'] as $code => $name) {
            $bank = new Bank();

            $bank->name = $name;
            $bank->identifier = $code;

            $bank->save();
        }
    }
}
