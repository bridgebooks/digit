<?php

Route::post('/', 'PayitemController@create');
Route::get('/{id}', 'PayitemController@read');
Route::put('/{id}', 'PayitemController@update');
Route::delete('/{id}', 'PayitemController@delete');
Route::post('/{id}/archive', 'PayitemController@archive');
Route::post('/{id}/restore', 'PayitemController@restore');