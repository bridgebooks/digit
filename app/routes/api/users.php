<?php

Route::post('/', 'CreateUserController@create');
Route::put('/{id}', 'UpdateUserController@update');
Route::post('/{id}/validate', 'CreateUserController@validateUser');

Route::post('/email', 'UpdateUserController@updateEmail');