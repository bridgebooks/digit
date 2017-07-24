<?php

Route::post('/password/reset', 'PasswordResetController@reset');
Route::post('/password/create', 'PasswordResetController@create');

Route::post('/login', 'AuthController@authenticate');
