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
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\BuildingController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\FolderController;
use App\Http\Controllers\API\GuestController;
use App\Http\Controllers\API\ItemController;
use App\Http\Controllers\API\PlanController;
use App\Http\Controllers\API\UnitController;
use App\Http\Controllers\API\ListingsController;
use App\Http\Controllers\API\PropertyFinder;
use App\Http\Controllers\API\CertificateController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GalleryController;



/*
|---------------------------------------------------------------------- ----
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('throttle:150,1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('', [UserController::class, 'getAll']);
            Route::get('{id}', [UserController::class, 'get']);
            Route::post('/logout', [UserController::class, 'logout']);
        });
    });

    Route::prefix('users')->group(function () {
        Route::post('', [UserController::class, 'create']);
        Route::post('/login', [UserController::class, 'login']);
    });
    
    Route::prefix('properties')->group(function () {   
        Route::get('', [PropertyController::class, 'getAll']);        
        Route::get('{id}', [PropertyController::class, 'get']);   
        Route::post('', [PropertyController::class, 'create']);     
        Route::put('', [PropertyController::class, 'update']);        
        Route::delete('{id}', [PropertyController::class, 'delete']);
    });
    
    Route::prefix('questions')->group(function () {   
        Route::get('', [QuestionController::class, 'getAll']);        
        Route::get('{id}', [QuestionController::class, 'get']);   
        Route::post('', [QuestionController::class, 'create']);     
        Route::put('', [QuestionController::class, 'update']);        
        Route::delete('{id}', [QuestionController::class, 'delete']);
    });
    
    Route::prefix('articles')->group(function () {   
        Route::get('', [ArticleController::class, 'getAll']);        
        Route::get('{id}', [ArticleController::class, 'get']);   
        Route::post('', [ArticleController::class, 'create']);     
        Route::put('', [ArticleController::class, 'update']);        
        Route::delete('{id}', [ArticleController::class, 'delete']);
    });
    
    Route::prefix('careers')->group(function () {   
        Route::get('', [CareerController::class, 'getAll']);        
        Route::get('{id}', [CareerController::class, 'get']);   
        Route::post('', [CareerController::class, 'add']);     
        // Route::put('', [CareerController::class, 'update']);        
        Route::delete('{id}', [CareerController::class, 'delete']);
    });
    
    Route::prefix('features')->group(function () {   
        Route::get('', [FeatureController::class, 'getAll']);        
        Route::get('{id}', [FeatureController::class, 'get']);   
        Route::post('', [FeatureController::class, 'create']);     
        Route::put('', [FeatureController::class, 'update']);        
        Route::delete('{id}', [FeatureController::class, 'delete']);
    });
    
    Route::prefix('facilities')->group(function () {   
        Route::get('', [FacilityController::class, 'getAll']);        
        Route::get('{id}', [FacilityController::class, 'get']);   
        Route::post('', [FacilityController::class, 'create']);     
        Route::put('', [FacilityController::class, 'update']);        
        Route::delete('{id}', [FacilityController::class, 'delete']);
    });
    
    Route::prefix('applications')->group(function () {   
        Route::get('', [ApplicationController::class, 'getAll']);        
        Route::get('{id}', [ApplicationController::class, 'get']);   
        Route::post('', [ApplicationController::class, 'add']);     
        // Route::put('', [ApplicationController::class, 'update']);        
        Route::delete('{id}', [ApplicationController::class, 'delete']);
    });
    
    Route::prefix('buildings')->group(function () {   
        Route::get('', [BuildingController::class, 'getAll']);        
        Route::get('{id}', [BuildingController::class, 'get']);   
        Route::post('', [BuildingController::class, 'create']);     
        Route::put('', [BuildingController::class, 'update']);        
        Route::delete('{id}', [BuildingController::class, 'delete']);
    });
    
    Route::prefix('plans')->group(function () {   
        Route::get('', [PlanController::class, 'getAll']);        
        Route::get('{id}', [PlanController::class, 'get']);   
        Route::post('', [PlanController::class, 'create']);     
        Route::put('', [PlanController::class, 'update']);        
        Route::delete('{id}', [PlanController::class, 'delete']);
    });
    
    Route::prefix('units')->group(function () {   
        Route::get('', [UnitController::class, 'getAll']);        
        Route::get('{id}', [UnitController::class, 'get']);   
        Route::post('', [UnitController::class, 'create']);     
        Route::put('', [UnitController::class, 'update']);        
        Route::delete('{id}', [UnitController::class, 'delete']);
    });
    
    Route::prefix('folders')->group(function () {   
        Route::get('', [FolderController::class, 'getAll']);        
        Route::get('{id}', [FolderController::class, 'get']);   
        Route::post('', [FolderController::class, 'add']);     
        Route::put('', [FolderController::class, 'update']);        
        Route::delete('{id}', [FolderController::class, 'delete']);
    });
    
    Route::prefix('files')->group(function () {   
        Route::get('', [FileController::class, 'getAll']);        
        Route::get('{id}', [FileController::class, 'get']);   
        Route::post('', [FileController::class, 'add']);     
        Route::put('', [FileController::class, 'update']);        
        Route::delete('{id}', [FileController::class, 'delete']);
    });
    
    Route::prefix('items')->group(function () {   
        Route::get('', [ItemController::class, 'getAll']);        
        Route::get('{id}', [ItemController::class, 'get']);   
        Route::post('', [ItemController::class, 'create']);     
        Route::put('', [ItemController::class, 'update']);        
        Route::delete('{id}', [ItemController::class, 'delete']);
    });
    
    Route::prefix('appointments')->group(function () {   
        Route::get('', [AppointmentController::class, 'getAll']);        
        Route::get('{id}', [AppointmentController::class, 'get']);   
        Route::post('', [AppointmentController::class, 'add']);     
        Route::put('', [AppointmentController::class, 'update']);        
        Route::delete('{id}', [AppointmentController::class, 'delete']);
    });
    
    Route::prefix('listings')->group(function () {   
        Route::get('', [ListingsController::class, 'getAll']);        
        Route::get('{id}', [ListingsController::class, 'get']);   
        Route::post('', [ListingsController::class, 'add']);     
        Route::put('', [ListingsController::class, 'update']);        
        Route::delete('{id}', [ListingsController::class, 'delete']);
    });
    
    Route::prefix('count')->group(function () {   
        Route::get('', [DashboardController::class, 'countProperties']);        
    });
    
    Route::prefix('listings')->group(function () {   
        Route::get('', [ListingsController::class, 'getAll']);        
        Route::get('{id}', [ListingsController::class, 'get']);   
        Route::post('', [ListingsController::class, 'add']);     
        Route::put('', [ListingsController::class, 'update']);        
        Route::delete('{id}', [ListingsController::class, 'delete']);
    });
    
    Route::prefix('certificates')->group(function () {
        Route::get('', [CertificateController::class, 'getAll']);
        Route::get('{id}', [CertificateController::class, 'get']);   
        Route::post('', [CertificateController::class, 'add']);     
        Route::put('', [CertificateController::class, 'update']);        
        Route::delete('{id}', [CertificateController::class, 'delete']);
    });
});

Route::prefix('galleries')->group(function () {   
    Route::get('', [GalleryController::class, 'getAll']);        
    Route::get('{id}', [GalleryController::class, 'get']);   
    Route::post('', [GalleryController::class, 'add']);     
    Route::delete('{id}', [GalleryController::class, 'delete']);
});

// Guest Routes

Route::prefix('giolo')->group(function () {   
    Route::get('recommended/{id}', [PropertyController::class, 'getPropertyAgent']);    
    Route::get('progress/{id}', [PropertyController::class, 'getPropertyAgent']);  
    Route::get('listings/{id}', [ListingsController::class, 'getListingsAgent']);   
    Route::post('contact', [ContactController::class, 'contact']); 
    Route::post('submitproperty', [GuestController::class, 'AddListings']);       
    
    // Property Finder
    Route::get('property-finder/{id}', [PropertyFinder::class, 'getPropertyFinder']);


});


