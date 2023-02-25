<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GithubApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'github'], function () {
    Route::get('/', [GithubApiController::class, 'index']);
    Route::get('/getList', [GithubApiController::class, 'index']);
    Route::get('/remove/{id}', [GithubApiController::class, 'remove']);
    Route::post('/store/{id?}', [GithubApiController::class, 'store']);
});


