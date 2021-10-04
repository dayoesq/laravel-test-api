<?php

use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\User\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/**
* Buyers.
*/
Route::resource('buyers', BuyerController::class, ['except' => ['create', 'edit']]);

/**
* Sellers.
*/
Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);

/**
* Categories.
*/
Route::resource('categories', CategoryController::class, ['only' => ['index', 'show']]);

/**
* Transactions.
*/
Route::resource('transactions', TransactionController::class, ['only' => ['index', 'show']]);

/**
* Users.
*/
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);

/**
* Products.
*/
Route::resource('products', ProductController::class, ['only' => ['index']]);

