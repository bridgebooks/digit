<?php

Route::post('/', 'CreateUserController@create');
Route::post('/{id}/validate', 'CreateUserController@validateUser');
