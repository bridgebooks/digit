<?php

Route::get('/{id}', 'PayslipController@get');
Route::post('/{id}/send', 'PayslipController@send');
Route::put('/items/{id}', 'PayslipController@updateItem');
Route::delete('/items/{id}', 'PayslipController@deleteItem');
Route::post('/{id}/items', 'PayslipController@add');
Route::get('/{id}/items', 'PayslipController@items');
