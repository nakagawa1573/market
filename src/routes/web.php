<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [ItemController::class, 'search'])->name('search');
Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', [RegisterController::class, 'store']);
Route::middleware('auth')->group(function(){
    Route::get('/mypage', [UserController::class, 'index']);
    Route::post('/item/comment/{item_id}', [ItemController::class, 'storeComment']);
    Route::post('/item/favorite/{item_id}', [ItemController::class, 'storeFavorite']);
    Route::delete('/item/favorite/{item_id}', [ItemController::class, 'destroy']);
    Route::get('/mypage/profile', [UserController::class, 'create']);
    Route::post('/mypage/profile', [UserController::class, 'store']);
    Route::patch('/mypage/profile', [UserController::class, 'update']);
    Route::get('/sell', [TransactionController::class, 'create']);
    Route::post('/sell', [TransactionController::class, 'store']);
    Route::get('/purchase/{item_id}', [TransactionController::class, 'show']);
    Route::post('/purchase/{item_id}', [TransactionController::class, 'buy']);
});
