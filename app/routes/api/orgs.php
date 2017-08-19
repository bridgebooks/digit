<?php

Route::get('/', 'OrgController@index');
Route::post('/', 'OrgController@create');
Route::post('/logo','OrgController@uploadLogo');
Route::get('/{id}', 'OrgController@one');
Route::put('/{id}', 'OrgController@update');
Route::get('/{id}/contacts', 'OrgController@contacts');