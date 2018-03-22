<?php

Route::get('/paystack', 'PaystackCallbackController@handle');
Route::get('/moneywave', 'MoneywaveCallbackController@handler');