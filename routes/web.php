<?php

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::get('/', function() {
    return redirect('/payments/test1');
});

Route::get('/transactions', 'TransactionsController@index');

// Route::get('/payments/{payment}', 'PaymentController@process');
Route::get('/payments/{payment}', 'Payment');


