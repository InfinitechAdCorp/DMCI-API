<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CareerController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\FeatureController;
use App\Http\Controllers\API\ApplicationController;
use App\Http\Controllers\API\BuildingController;
use App\Http\Controllers\API\PlanController;

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
    // Route::put('{id}', [PropertyController::class, 'update']);        
    Route::delete('{id}', [PropertyController::class, 'delete']);
});

Route::prefix('questions')->group(function () {   
    Route::get('', [QuestionController::class, 'getAll']);        
    Route::get('{id}', [QuestionController::class, 'get']);   
    Route::post('', [QuestionController::class, 'add']);     
    Route::put('{id}', [QuestionController::class, 'update']);        
    Route::delete('{id}', [QuestionController::class, 'delete']);
});

Route::prefix('articles')->group(function () {   
    Route::get('', [ArticleController::class, 'getAll']);        
    Route::get('{id}', [ArticleController::class, 'get']);   
    Route::post('', [ArticleController::class, 'add']);     
    // Route::put('{id}', [ArticleController::class, 'update']);        
    Route::delete('{id}', [ArticleController::class, 'delete']);
});

Route::prefix('careers')->group(function () {   
    Route::get('', [CareerController::class, 'getAll']);        
    Route::get('{id}', [CareerController::class, 'get']);   
    Route::post('', [CareerController::class, 'add']);     
    // Route::put('{id}', [CareerController::class, 'update']);        
    Route::delete('{id}', [CareerController::class, 'delete']);
});

Route::prefix('features')->group(function () {   
    Route::get('', [FeatureController::class, 'getAll']);        
    Route::get('{id}', [FeatureController::class, 'get']);   
    Route::post('', [FeatureController::class, 'add']);     
    Route::put('{id}', [FeatureController::class, 'update']);        
    Route::delete('{id}', [FeatureController::class, 'delete']);
});

Route::prefix('facilities')->group(function () {   
    Route::get('', [FacilityController::class, 'getAll']);        
    Route::get('{id}', [FacilityController::class, 'get']);   
    Route::post('', [FacilityController::class, 'add']);     
    // Route::put('{id}', [FacilityController::class, 'update']);        
    Route::delete('{id}', [FacilityController::class, 'delete']);
});

Route::prefix('applications')->group(function () {   
    Route::get('', [ApplicationController::class, 'getAll']);        
    Route::get('{id}', [ApplicationController::class, 'get']);   
    Route::post('', [ApplicationController::class, 'add']);     
    // Route::put('{id}', [ApplicationController::class, 'update']);        
    Route::delete('{id}', [ApplicationController::class, 'delete']);
});

Route::prefix('buildings')->group(function () {   
    Route::get('', [BuildingController::class, 'getAll']);        
    Route::get('{id}', [BuildingController::class, 'get']);   
    Route::post('', [BuildingController::class, 'add']);     
    // Route::put('{id}', [BuildingController::class, 'update']);        
    Route::delete('{id}', [BuildingController::class, 'delete']);
});

Route::prefix('plans')->group(function () {   
    Route::get('', [PlanController::class, 'getAll']);        
    Route::get('{id}', [PlanController::class, 'get']);   
    Route::post('', [PlanController::class, 'add']);     
    // Route::put('{id}', [PlanController::class, 'update']);        
    Route::delete('{id}', [PlanController::class, 'delete']);
});