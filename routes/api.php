<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Admin\MoviesController as AdminMovieController;

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

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    //View all movies, and view a single movie
    Route::get('/movies', [MovieController::class, 'index']);
    Route::post('/movies/search', [MovieController::class, 'search']);
    Route::get('/movies/recent', [MovieController::class, 'recent']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);
    Route::post('/movies/upload', [AdminMovieController::class, 'upload']);

    //View all reviews (owned only), edit a reviews (owned only), delete a reviews (owned only)
    Route::get('/reviews/recent', [ReviewController::class, 'recent']);
    Route::resource('reviews', ReviewController::class)->except(['create', 'edit', 'show', 'update', 'destroy', 'index']);
});

