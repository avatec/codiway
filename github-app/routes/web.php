<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GithubController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'github'], function () {
    Route::get('/', [GithubController::class, 'index'])->name('github');
    Route::get('/add', [GithubController::class, 'add'])->name('github.add');
    Route::get('/{id}', [GithubController::class, 'show'])->name('github.show');
    Route::match(['post', 'patch'], '/store/{id?}', [GithubController::class, 'store'])->name('github.store');
    Route::delete('/remove/{id}', [GithubController::class, 'remove'])->name('github.remove');
});

require __DIR__.'/auth.php';
