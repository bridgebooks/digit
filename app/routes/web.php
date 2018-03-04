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

    $balanceDate = "2018-03-31";
    $reportEndDate = new \Carbon\Carbon($balanceDate);
    $reportStartDate = $reportEndDate->copy()->subYear();

    $balanceSheetService = new \App\Services\Reports\BalancesheetReportService();
    $report = $balanceSheetService->generate("ad8cd4e0-0ded-11e8-b914-5fec8f4b73a9", $reportStartDate, $reportEndDate);
	return view('reports.balance-sheet', $report)->with([
	    "org" => \App\Models\Org::find("ad8cd4e0-0ded-11e8-b914-5fec8f4b73a9"),
        "balance_date" => $reportEndDate->format("d F Y")
    ]);
});