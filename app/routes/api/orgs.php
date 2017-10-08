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
Route::get('{id}/sales', 'OrgInvoiceController@sales');
Route::get('{id}/bills', 'OrgInvoiceController@sales');
Route::get('{id}/invoice_events', 'OrgInvoiceController@invoiceEvents');
Route::get('{id}/invoice_settings', 'OrgInvoiceSettingController@get');
Route::put('{id}/invoice_settings', 'OrgInvoiceSettingController@update');

// Org Contact Groups
Route::post('/{id}/contact_groups', 'OrgContactsController@createContactGroup');
Route::get('/{id}/contact_groups', 'OrgContactsController@contactGroups');

// Org Bank Accounts
Route::post('/{id}/bank_accounts', 'OrgBankAccountController@create');
Route::get('/{id}/bank_accounts', 'OrgBankAccountController@index');
Route::put('/{org_id}/bank_accounts/{id}', 'OrgBankAccountController@update');
Route::delete('/{org_id}/bank_accounts/{id}', 'OrgBankAccountController@delete');

