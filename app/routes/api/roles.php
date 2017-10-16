<?php

Route::post('/', 'RoleController@create');
Route::get('/', 'RoleController@index');
Route::get('/orgs', 'RoleController@org');
