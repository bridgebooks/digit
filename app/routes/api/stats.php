<?php

Route::get('{id}/sales', 'SalesStatsController@generate');
Route::get('{id}/bills', 'BillStatsController@generate');
Route::get('{id}/receivables', 'ReceivableStatsController@generate');