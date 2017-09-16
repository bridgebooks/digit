<?php

Route::post('/', 'SalePurchaseItemController@create');
Route::get('/{id}', 'SalePurchaseItemController@get');
Route::put('/{id}', 'SalePurchaseItemController@update');
Route::delete('/{id}', 'SalePurchaseItemController@delete');