<?php

use FatemeMahmoodi\LaravelToDo\Http\Controllers\LabelController;
use FatemeMahmoodi\LaravelToDo\Http\Controllers\TaskController;
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


Route::group( ['middleware' => config('laravel_todo.middlewares')], function () {
    Route::resource('labels', LabelController::class);
    Route::resource('tasks', TaskController::class);
});

