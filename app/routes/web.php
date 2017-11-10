<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	//$invoice = \App\Models\Invoice::with(['org','contact','items', 'items.item'])->find('5e76aea0-a988-11e7-a54e-4f1aff114730');
    //return view('invoices.standard', ['invoice' => $invoice]);
    echo "ksnlgs";
});