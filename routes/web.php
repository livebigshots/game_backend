<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ColorPredictionController;
use App\Http\Controllers\NumberPredictionController;

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
    return view('auth.login');
});



Route::middleware(['middleware' => 'auth', 'cors'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('user-list', [UserController::class, 'index'])->name('user-list');

    Route::get('user-detail/{id}', [UserController::class, 'userDetail'])->name('user-detail');

    Route::post('profile', [AdminController::class, 'profile'])->name('profile');

    Route::get('profile', [AdminController::class, 'changePassword'])->name('profile');

    Route::post('change-password', [AdminController::class, 'changePasswordForm'])->name('change-password');

    Route::post('change-account-detail', [AdminController::class, 'changeAccountDetail'])->name('change-account-detail');

    Route::get('color-prediction-list', [ColorPredictionController::class, 'index'])->name('color-prediction-list');

    Route::get('number-prediction-list', [NumberPredictionController::class, 'index'])->name('number-prediction-list');

    Route::get('game-details/{id}', [ColorPredictionController::class, 'gameEdit'])->name('game-details');

    Route::post('update-color', [ColorPredictionController::class, 'updateColor'])->name('update-color');

    Route::get('number-game-details/{id}', [NumberPredictionController::class, 'gameEdit'])->name('number-game-details');

    Route::post('update-number', [NumberPredictionController::class, 'updateNumber'])->name('update-number');

    Route::get('payment-list', [PaymentController::class, 'index'])->name('payment-list');

    Route::get('payment-details/{id}', [PaymentController::class, 'paymentDetail'])->name('payment-details');

    Route::post('update-payment', [PaymentController::class, 'updatePayment'])->name('update-payment');

    Route::get('withdraw-list', [WithdrawController::class, 'index'])->name('withdraw-list');

    Route::get('withdraw-details/{id}', [WithdrawController::class, 'withdrawDetail'])->name('withdraw-details');

    Route::post('update-withdraw', [WithdrawController::class, 'updateWithdraw'])->name('update-withdraw');

    Route::get('contact-list', [ContactUsController::class, 'index'])->name('contact-list');

    Route::get('contact-detail/{id}', [ContactUsController::class, 'detail'])->name('contact-details');
});

require __DIR__.'/auth.php';
