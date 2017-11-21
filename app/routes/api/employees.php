<?php

Route::post('/', 'EmployeeController@create');
Route::get('/{id}', 'EmployeeController@read');
Route::put('/{id}', 'EmployeeController@update');
Route::delete('/{id}', 'EmployeeController@delete');

