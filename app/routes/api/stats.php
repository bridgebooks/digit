<?php

Route::get('{id}/invoices', 'InvoiceStatsController@generate');
Route::get('{id}/sales', 'SalesStatsController@generate');
Route::get('{id}/bills', 'BillStatsController@generate');
Route::get('{id}/receivables', 'ReceivableStatsController@generate');
Route::get('{id}/pl', 'PLStatsController@generate');