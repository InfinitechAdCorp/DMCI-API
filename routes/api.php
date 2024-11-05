<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('categories')->group(function () {   
    Route::get('', [CategoryController::class, 'getAll']);        
    Route::get('{id}', [CategoryController::class, 'get']);   
    Route::post('', [CategoryController::class, 'add']);     
    Route::put('{id}', [CategoryController::class, 'update']);        
    Route::delete('{id}', [CategoryController::class, 'delete']);
});

Route::prefix('properties')->group(function () {   
    Route::get('', [PropertyController::class, 'getAll']);        
    Route::get('{id}', [PropertyController::class, 'get']);   
    Route::post('', [PropertyController::class, 'add']);     
    Route::put('{id}', [PropertyController::class, 'update']);        
    Route::delete('{id}', [PropertyController::class, 'delete']);
});