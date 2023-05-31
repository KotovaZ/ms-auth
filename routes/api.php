<?php

use App\Http\Controllers\Login;
use App\Http\Controllers\SessionLogin;
use App\Http\Controllers\SessionRegister;
use Illuminate\Support\Facades\Route;


Route::post('/login', [Login::class, 'getJWT']);
Route::post('/session', [SessionRegister::class, 'register']);
Route::get('/session', [SessionRegister::class, 'get']);
Route::post('/session/{id}', [SessionLogin::class, 'login']);
