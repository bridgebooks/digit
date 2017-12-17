<?php

Route::put('/items/{id}', 'PayslipController@updateItem');
Route::delete('/items/{id}', 'PayslipController@deleteItem');
Route::post('/{id}/items', 'PayslipController@add');
Route::get('/{id}/items', 'PayslipController@items');
