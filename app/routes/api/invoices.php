<?php

Route::post('/', 'InvoiceController@create');
Route::get('/{id}', 'InvoiceController@get');
Route::put('/{id}', 'InvoiceController@update');

Route::post('/{id}/send', 'InvoiceController@send');