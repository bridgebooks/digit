<?php

Route::post('/', 'AccountController@create');
Route::get('/account_types', 'AccountController@types');
Route::get('/{id}', 'AccountController@get');
Route::put('/{id}', 'AccountController@update');
Route::delete('/{id}', 'AccountController@delete');
Route::post('/delete/bulk', 'AccountController@bulkDelete');
