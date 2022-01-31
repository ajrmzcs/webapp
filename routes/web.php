<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/import', 'ContactController@store');
    Route::get('/show-records', 'HomeController@showRecords');
    Route::get('/records', 'ContactController@getRecords');
});
