<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebhookController;
use App\Models\User;
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
    Route::get('/mypage/profile', [UserController::class, 'createProfile']);
    Route::post('/mypage/profile', [UserController::class, 'storeProfile']);
    Route::patch('/mypage/profile', [UserController::class, 'update']);
    Route::get('/purchase/delivery', [UserController::class, 'createDelivery']);
    Route::post('/purchase/delivery', [UserController::class, 'storeDelivery']);
    Route::delete('/purchase/delivery', [UserController::class, 'destroy']);

    Route::post('/item/comment/{item_id}', [ItemController::class, 'storeComment']);
    Route::delete('/item/comment/{comment_id}', [ItemController::class, 'destroyComment']);
    Route::post('/item/favorite/{item_id}', [ItemController::class, 'storeFavorite']);
    Route::delete('/item/favorite/{item_id}', [ItemController::class, 'destroyFavorite']);

    Route::get('/sell', [TransactionController::class, 'create']);
    Route::post('/sell', [TransactionController::class, 'store']);
    Route::get('/purchase/{item_id}', [TransactionController::class, 'show']);
    Route::post('/purchase/{item_id}', [TransactionController::class, 'buy']);

    Route::post('/stripe', [StripeController::class, 'store']);
    Route::get('/stripe/{account_id}', [StripeController::class, 'update']);

    Route::get('/admin', [AdminController::class, 'index']);
    Route::delete('/admin/delete', [AdminController::class, 'destroy']);
    Route::post('/admin/email', [AdminController::class, 'send']);
});
