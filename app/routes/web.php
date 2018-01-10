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

	$slip = \App\Models\Payslip::with(['payrun', 'employee'])
        ->find('a7b19220-f399-11e7-8636-8112971985bb');

    return view('emails.payroll.payslip', [
        'slip'=> $slip
    ]);
});