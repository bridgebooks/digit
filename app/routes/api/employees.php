<?php

Route::post('/', 'EmployeeController@create');
Route::get('/{id}', 'EmployeeController@read');
Route::put('/{id}', 'EmployeeController@update');
Route::delete('/{id}', 'EmployeeController@delete');
Route::post('/delete/bulk', 'EmployeeController@bulkDelete');
Route::post('/archive/bulk', 'EmployeeController@bulkArchive');
Route::post('/restore/bulk', 'EmployeeController@bulkRestore');
Route::post('/terminate/bulk', 'EmployeeController@bulkTerminate');


