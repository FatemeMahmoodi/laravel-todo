<?php

use Illuminate\Http\Request;
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


Route::group( ['prefix' => 'laravel_todo' ,'middleware' => ['api']], function () {
    Route::resource('labels', LabelController::class);
    Route::resource('tasks', TaskController::class);
});

