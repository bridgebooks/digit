<?php

Route::get('/', 'OrgController@index');
Route::post('/', 'OrgController@create');

Route::post('/logo','OrgController@uploadLogo');

Route::get('/{id}', 'OrgController@one');
Route::put('/{id}', 'OrgController@update');

Route::get('/{id}/employees', 'OrgEmployeeController@all');
Route::get('/{id}/payruns', 'OrgPayrunController@all');
Route::get('/{id}/accounts', 'OrgAccountsController@all');
Route::get('/{id}/tax_rates', 'OrgTaxRateController@all');
Route::get('/{id}/contacts', 'OrgContactsController@contacts');
Route::get('/{id}/items', 'OrgItemsController@all');
Route::get('/{id}/payitems', 'OrgPayitemController@all');
Route::get('{id}/invoices', 'OrgInvoiceController@invoices');
Route::get('{id}/invoice_events', 'OrgInvoiceController@invoiceEvents');

Route::get('{id}/settings/invoices', 'OrgInvoiceSettingController@get');
Route::get('{id}/settings/payruns', 'OrgPayrunSettingController@get');

Route::put('{id}/settings/payruns', 'OrgPayrunSettingController@update');
Route::put('{id}/settings/invoices', 'OrgInvoiceSettingController@update');

//Org Users
Route::get('{id}/users', 'OrgUserController@all');
Route::post('{id}/users/invite', 'OrgUserController@invite');
Route::delete('{id}/users/{user_id}', 'OrgUserController@delete');
// Org Contact Groups
Route::post('/{id}/contact_groups', 'OrgContactsController@createContactGroup');
Route::get('/{id}/contact_groups', 'OrgContactsController@contactGroups');

// Org Bank Accounts
Route::post('/{id}/bank_accounts', 'OrgBankAccountController@create');
Route::get('/{id}/bank_accounts', 'OrgBankAccountController@index');
Route::put('/{org_id}/bank_accounts/{id}', 'OrgBankAccountController@update');
Route::delete('/{org_id}/bank_accounts/{id}', 'OrgBankAccountController@delete');

