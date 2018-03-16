<?php

Route::get('/{id}/balance-sheet', 'BalanceSheetController@generate');
Route::get('/{id}/profit-loss', 'ProfitLossController@generate');
Route::get('{id}/aged-invoices', 'AgeInvoiceController@generate');