<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/transaction', 'App\Http\Controllers\WTController');
Route::post('transaction/{id}/deliver', 'App\Http\Controllers\DeliveryController');
Route::post('transaction/{id}/cancel', 'App\Http\Controllers\CancelingController');
