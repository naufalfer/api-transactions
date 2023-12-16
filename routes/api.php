<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemTypeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;

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

Route::get('item_type', [ItemTypeController::class, 'index']);
Route::get('item_type/{id}', [ItemTypeController::class, 'show']);
Route::post('item_type', [ItemTypeController::class, 'store']);
Route::put('item_type/{id}', [ItemTypeController::class, 'update']);
Route::delete('item_type/{id}', [ItemTypeController::class, 'destroy']);

Route::get('items', [ItemController::class, 'index']);
Route::get('items/search', [ItemController::class, 'itemSearch']);
Route::get('items/{id}', [ItemController::class, 'show']);
Route::post('items', [ItemController::class, 'store']);
Route::put('items/{id}', [ItemController::class, 'update']);
Route::delete('items/{id}', [ItemController::class, 'destroy']);

Route::get('transactions', [TransactionController::class, 'index']);
Route::get('transactions-sold', [TransactionController::class, 'indexTransactionSold']);
Route::get('transactions/search', [TransactionController::class, 'transactionSearch']);
Route::get('transactions/{id}', [TransactionController::class, 'show']);
Route::post('transactions', [TransactionController::class, 'store']);
Route::put('transactions/{id}', [TransactionController::class, 'update']);
Route::delete('transactions/{id}', [TransactionController::class, 'destroy']);


