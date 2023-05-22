<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ListController;
use App\Http\Controllers\Api\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    //View all movies, and view a single movie
    Route::get('/movies', [MovieController::class, 'index']);
    Route::post('/movies/search', [MovieController::class, 'search']);
    Route::get('/movies/recent', [MovieController::class, 'recent']);
    Route::get('/movies/{id}', [MovieController::class, 'show']);

    //View all reviews (owned only), edit a reviews (owned only), delete a reviews (owned only)
    Route::get('/reviews/:movieId', [ReviewController::class, 'index']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::patch('/reviews/:id', [ReviewController::class, 'update']);
    Route::delete('/reviews/:id', [ReviewController::class, 'destroy']);
    Route::get('/reviews/recent', [ReviewController::class, 'recent']);
    
});

