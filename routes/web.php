<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserOrdersController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|cs1|cs2',
])->group(function () {

    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });


    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('products/data', [ProductController::class, 'getProduk'])->name('products.data');
    Route::get('products/import', [ProductController::class, 'importView'])->name('products.import.view');
    Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('products/template/download', [ProductController::class, 'downloadTemplate'])->name('products.template.download');

    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');

    Route::resource('orders', OrderController::class)->except(['show']);
    Route::get('orders/data', [OrderController::class, 'getOrders'])->name('orders.data');
    Route::get('/orders/blinking-count', [OrderController::class, 'countBlinkingOrders'])
        ->name('orders.blink.count');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('orders/{id}/upload', [OrderController::class, 'uploadPayment'])->name('orders.upload');
    Route::get('orders/import', [OrderController::class, 'importView'])->name('orders.import.view');
    Route::post('orders/import', [OrderController::class, 'import'])->name('orders.import');
    Route::get('orders/template/download', [OrderController::class, 'downloadTemplate'])->name('orders.template.download');
    Route::get('orders/{id}/items', [OrderController::class, 'getOrderItems'])->name('orders.items');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});



Route::controller(ShopController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/products/{id}', 'show')->name('products.show');
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::post('/cart/checkout', 'checkout')->name('cart.checkout');
    Route::get('/checkout/pilih', [ShopController::class, 'choose'])->name('checkout.choose');
    Route::get('/checkout/guest', [ShopController::class, 'guest'])->name('checkout.guest');
    Route::get('/checkout/process', [ShopController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/submit', [ShopController::class, 'submit'])
        ->name('checkout.submit');
    Route::get('/checkout/success', [ShopController::class, 'success'])
        ->name('checkout.success');
    Route::get('/payment/upload/{order}', [PaymentController::class, 'uploadForm'])
        ->name('payment.upload');
    Route::post('/payment/upload/{order}', [PaymentController::class, 'upload'])
        ->name('payment.upload.save');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orderan/history', [UserOrdersController::class, 'index'])->name('orderan.history');
    Route::get('/orderan/upload/{order}', [UserOrdersController::class, 'uploadForm'])
        ->name('orderan.upload');
    Route::post('/orderan/upload/{order}', [UserOrdersController::class, 'upload'])
        ->name('orderan.upload.save');
    Route::put('/orderan/{order}/complete', [UserOrdersController::class, 'markComplete'])->name('orderan.markComplete');
});
