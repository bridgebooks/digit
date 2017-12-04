<?php

Route::post('/', 'PayrunController@create');
Route::get('/{id}', 'PayrunController@read');
Route::put('/{id}', 'PayrunController@update');