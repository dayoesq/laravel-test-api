<?php

use App\Http\Controllers\Buyer\BuyerProductController;
use App\Http\Controllers\Buyer\BuyerTransactionController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Transaction\TransactionCategoryController;
use App\Http\Controllers\Transaction\TransactionSellerController;
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
 * Buyers transactions.
 */
Route::resource('buyers.transactions', BuyerTransactionController::class, ['only' => ['index']]);

/**
 * Buyers products.
 */
Route::resource('buyers.products', BuyerProductController::class, ['only' => ['index']]);


/**
* Sellers.
*/
Route::resource('sellers', SellerController::class, ['only' => ['index', 'show']]);

/**
* Categories.
*/
Route::resource('categories', CategoryController::class, ['except' => ['create', 'edit']]);

/**
* Transactions.
*/
Route::resource('transactions', TransactionController::class, ['only' => ['index', 'show']]);

/**
 * Transaction categories.
 */
Route::resource('transactions.categories', TransactionCategoryController::class, ['only' => ['index']]);

/**
 * Transaction sellers.
 */
Route::resource('transactions.sellers', TransactionSellerController::class, ['only' => ['index']]);

/**
* Users.
*/
Route::resource('users', UserController::class, ['except' => ['create', 'edit']]);

/**
* Products.
*/
Route::resource('products', ProductController::class, ['only' => ['index', 'show']]);

