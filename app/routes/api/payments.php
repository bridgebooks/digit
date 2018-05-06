<?php

Route::get('/paystack', 'PaystackCallbackController@handle');
Route::get('/moneywave', 'MoneywaveCallbackController@handle');
Route::post('/receive', 'PaymentReceiveController@handle');