<?php

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/transactions', 'TransactionsController@index');

// Route::get('/payments/{payment}', 'PaymentController@process');
Route::get('/payments/{payment}', 'Payment');


