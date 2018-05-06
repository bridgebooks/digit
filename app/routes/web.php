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

    $invoice = \App\Models\Invoice::with(['org','payment'])->find("597a0100-3586-11e8-b20a-81b8968ef30e");

    return view("emails.invoices.receipt")->with([
        'invoice' => $invoice
    ]);
});