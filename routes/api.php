<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')
    ->group(function () {
        Route::post('/token', \App\Http\Controllers\Authentication\LoginPostController::class);
        Route::post('/register', \App\Http\Controllers\Authentication\RegisterPostController::class);
    });


Route::prefix('files')
    ->middleware('jwt.verify')
    ->group(function () {
        Route::get('/', \App\Http\Controllers\File\FileGetController::class);
        Route::post('/', \App\Http\Controllers\File\FilePostController::class);
        Route::post('/delete/{id}', \App\Http\Controllers\File\FileDeleteController::class);
        Route::post('/bulk', \App\Http\Controllers\File\FileBulkPostController::class);
    });
