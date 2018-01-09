<?php

Route::post('/', 'PayrunController@create');
Route::get('/{id}', 'PayrunController@read');
Route::put('/{id}', 'PayrunController@update');
Route::put('/{id}/approve', 'PayrunController@approve');