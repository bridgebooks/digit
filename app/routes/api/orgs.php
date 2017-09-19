<?php

Route::get('/', 'OrgController@index');
Route::post('/', 'OrgController@create');

Route::post('/logo','OrgController@uploadLogo');

Route::get('/{id}', 'OrgController@one');
Route::put('/{id}', 'OrgController@update');

Route::get('/{id}/accounts', 'OrgAccountsController@all');
Route::get('/{id}/tax_rates', 'OrgTaxRateController@all');
Route::get('/{id}/contacts', 'OrgContactsController@contacts');
Route::get('/{id}/items', 'OrgItemsController@all');

Route::post('/{id}/contact_groups', 'OrgContactsController@createContactGroup');
Route::get('/{id}/contact_groups', 'OrgContactsController@contactGroups');

Route::post('/{id}/bank_accounts', 'OrgBankAccountController@add');
Route::get('/{id}/bank_accounts', 'OrgBankAccountController@index');