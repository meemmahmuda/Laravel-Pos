<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PurchaseController;

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

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('purchases', PurchaseController::class);
Route::get('purchases/{purchase}/invoice', [PurchaseController::class, 'printInvoice'])->name('purchases.invoice');

