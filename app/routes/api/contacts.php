<?php

Route::post('/', 'ContactController@create');

Route::get('/{id}', 'ContactController@one');
Route::put('/{id}', 'ContactController@update');
Route::delete('/{id}', 'ContactController@delete');

Route::post('/{id}/people', 'ContactPersonController@create');
Route::delete('/{id}/people/{person_id}', 'ContactPeopleController@delete');