<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mrfoh\Mulla\Api\Plans;
use Mrfoh\Mulla\Exceptions\InvalidRequestException;

class TestController
{
    public function test(Request $request, Plans $plans) {

        $plan = $plans->update('PLN_vv86sckrg3pyy3b', ['amount' => 350000]);
        dd($plan); 
    }
}