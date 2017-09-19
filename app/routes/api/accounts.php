<?php

Route::post('/', 'AccountController@create');
Route::get('/{id}', 'AccountController@get');
Route::put('/{id}', 'AccountController@update');
Route::delete('/{id}', 'AccountController@delete');