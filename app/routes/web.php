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

	$invoice = \App\Models\Invoice::find("d7b48420-09aa-11e8-9228-1371adb918f5");
	$items = $invoice->items;
	$itemGroups = $items->groupBy("account_id");
	$itemGroups->each(function ($group) {
	   $group->each(function ($item) {
	      dd($item);
       });
    });
});