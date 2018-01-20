<?php

Route::post('/', 'CreateUserController@create');
Route::put('/{id}', 'UpdateUserController@update');
Route::post('/{id}/validate', 'CreateUserController@validateUser');

Route::post('/email', 'UpdateUserController@updateEmail');
Route::post('/password', 'UpdateUserController@updatePassword');

Route::get('/billing', 'UserBillingController@active');
Route::post('/billing/subscriptions', 'UserBillingController@subscription');
Route::post('/billing/subscriptions/cancel', 'UserBillingController@cancel');