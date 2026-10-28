<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyBillController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\EnsureCustomer;
use App\Http\Middleware\EnsureStaff;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(EnsureStaff::class)->group(function () {
    Route::resource('customers', CustomerController::class)->except('show');

    Route::resource('bills', BillController::class)->only(['index', 'create', 'store', 'show']);
    Route::post('/bills/{bill}/advance', [BillController::class, 'advance'])->name('bills.advance');
    Route::post('/bills/{bill}/pay', [BillController::class, 'pay'])->name('bills.pay');
});

Route::get('/my-bills', [MyBillController::class, 'index'])
    ->middleware(EnsureCustomer::class)
    ->name('my-bills');
