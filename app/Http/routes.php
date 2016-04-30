<?php

Route::get('/{author?}', [
    'uses' => 'QuoteController@getIndex',
    'as' => 'index'
]);

Route::get('/edit/{quote_id}', [
    'uses' => 'QuoteController@getEdit',
    'as' => 'edit'
]);

Route::post('/new', [
    'uses' => 'QuoteController@postQuote',
    'as' => 'create'
]);

Route::get('/delete/{quote_id}', [
    'uses' => 'QuoteController@getDeleteQuote',
    'as' => 'delete'
]);

Route::put('/update', [
    'uses' => 'QuoteController@putQuote',
    'as' => 'update'
]);
