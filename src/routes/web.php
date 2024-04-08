<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
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
Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', [RegisterController::class, 'store']);
Route::middleware('auth')->group(function(){
    Route::get('/mypage', [UserController::class, 'index']);
    Route::post('/item/comment/{item_id}', [UserController::class, 'storeComment']);
    Route::post('/item/favorite/{item_id}', [UserController::class, 'storeFavorite']);
    Route::delete('/item/favorite/{item_id}', [UserController::class, 'destroy']);
});
