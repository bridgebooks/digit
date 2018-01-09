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

	$slip = \App\Models\Payslip::with(['payrun', 'payrun.org', 'employee'])
        ->find('c3281d10-ef80-11e7-9758-3fd3719e6399');

	$allowances = $slip->items->filter(function ($paySlipItem) {
	   return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::ALLOWANCE;
    });

    $wages = $slip->items->filter(function ($paySlipItem) {
        return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::WAGES;
    });

    $reimbursements = $slip->items->filter(function ($paySlipItem) {
        return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::REIMBURSEMENT;
    });

    $deductions = $slip->items->filter(function ($paySlipItem) {
        return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::DEDUCTION;
    });

    $tax = $slip->items->filter(function ($paySlipItem) {
        return $paySlipItem->item->pay_item_type === \App\Models\Enums\PayitemType::TAX;
    });

    $earnings = $allowances->concat($wages, $reimbursements)
        ->map(function ($item) {
            return $item->amount;
        })
        ->sum();

    $less = $deductions->concat($tax)
        ->map(function ($item) {
            return $item->amount;
        })
        ->sum();

    return view('payslips.standard', [
        'wages' => $wages,
        'allowances' => $allowances,
        'reimbursements' => $reimbursements,
        'deductions' => $deductions,
        'earnings' => $earnings,
        'gross_deductions' => $less,
        'slip' => $slip
    ]);
});