<?php

Route::post('/', 'InvoiceController@create');
Route::get('/{id}', 'InvoiceController@get');
Route::put('/{id}', 'InvoiceController@update');
Route::get('/payments/{id}', 'InvoicePaymentController@get');
Route::post('/{id}/download', 'InvoiceController@download');
Route::post('{id}/payment', 'InvoicePaymentController@init');
Route::post('{id}/verify_payment', 'InvoicePaymentController@verify');

Route::post('/{id}/send', 'InvoiceController@send');
Route::put('/items/{id}', 'InvoiceItemController@update');
Route::delete('/items/{id}', 'InvoiceItemController@delete');