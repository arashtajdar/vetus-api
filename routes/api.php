<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationImageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\UserBadgeController;
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
Route::get('/', function () {
    return 'welcome to api';
});



Route::get('/test', function () {
    return 'Test';
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('/login/callback', [SocialiteController::class, 'handleProviderCallback']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('locations', LocationController::class)->except(['create', 'edit', 'find']);
Route::post('findByCoords', [LocationController::class, 'find']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Categories
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);

    // Location Images
    Route::resource('location-images', LocationImageController::class)->except(['create', 'edit', 'update']);

    // Reviews
    Route::resource('reviews', ReviewController::class)->except(['create', 'edit', 'update']);

    // Suggestions
    Route::resource('suggestions', SuggestionController::class)->except(['create', 'edit', 'update']);

    // User Badges
    Route::resource('user-badges', UserBadgeController::class)->except(['create', 'edit', 'update']);

    Route::post('favourites', [FavoriteController::class, 'store']);
    Route::post('favourites/remove', [FavoriteController::class, 'destroy']);
    Route::post('favourites/fetchAll', [FavoriteController::class, 'index']);

});
