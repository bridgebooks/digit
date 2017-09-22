<?php

Route::post('/', 'TaxRateController@create');
Route::get('/account_types', 'TaxRateController@types');
Route::get('/{id}', 'TaxRateController@get');
Route::put('/{id}', 'TaxRateController@update');
Route::delete('/{id}', 'TaxRateController@delete');
Route::post('/delete/bulk', 'TaxRateController@bulkDelete');
