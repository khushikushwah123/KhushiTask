<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Product CRUD
Route::post('add-product', [ProductController::class, 'add_product']);
Route::post('edit-product', [ProductController::class, 'edit_product']);
Route::post('view-product', [ProductController::class, 'view_product']);
Route::post('product-list', [ProductController::class, 'product_list']);
Route::post('delete-product', [ProductController::class, 'delete_product']);

// Cart
Route::post('add-to-cart', [CartController::class, 'add_to_cart']);
Route::get('cart-list', [CartController::class, 'cart_list']);
Route::post('delete-product-from-cart', [CartController::class, 'delete_product_from_cart']);
