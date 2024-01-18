<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\ProductController;
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

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{id}/add-to-cart', [ProductController::class, 'addToCart'])->name('products.addToCart');
Route::post('/products/add-to-cart-ajax', [ProductController::class, 'addToCartAjax'])->name('products.addToCartAjax');
Route::post('/products/update-to-cart-ajax', [ProductController::class, 'updateToCartAjax'])->name('products.updateToCartAjax');

Route::controller(PaypalController::class)
    ->prefix('paypal')
    ->group(function () {
        Route::view('payment', 'transaction')->name('create.payment');
        Route::get('handle-payment', 'handlePayment')->name('make.payment');
        Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
        Route::get('payment-success', 'paymentSuccess')->name('success.payment');
    });

Route::prefix('admin')->as('admin.')->group(function () {
    Route::middleware('adminLogin')->group(function () {
        Route::get('/login', [AuthController::class, 'adminLogin'])->name('login');
        Route::post('/login-process', [AuthController::class, 'adminLoginProcess'])->name('login.process');
    });

    Route::middleware('adminDashboard')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'adminlogout'])->name('logout');
    });
});

Route::prefix('user')->as('user.')->group(function () {
    Route::middleware('userLogin')->group(function () {
        Route::get('/login', [AuthController::class, 'userLogin'])->name('login');
        Route::post('/login-process', [AuthController::class, 'userLoginProcess'])->name('login.process');
    });

    Route::middleware('userDashboard')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('dashboard');
        Route::get('/logout', [AuthController::class, 'userlogout'])->name('logout');
    });
});
