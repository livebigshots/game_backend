<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\WithdrawController;
use App\Http\Controllers\Api\ContactUsController;
use App\Http\Controllers\Api\GamePredictionController;
use App\Http\Controllers\Api\ColorPredictionController;
use App\Http\Controllers\Api\NumberPredictionController;


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
Route::group(['middleware' => ['throttle:api']], function ($router) {

    Route::post('register', [UserController::class, 'register']);

    Route::post('login', [UserController::class, 'login']);

    Route::post('forgot_password', [UserController::class, 'forgotPassword']);

    Route::post('change_password', [UserController::class, 'changePassword']);

    Route::middleware('auth:api')->group(function () {

        Route::prefix('user')->group(function () {
            Route::get('list', [UserController::class, 'userList']);
            Route::post('edit', [UserController::class, 'userEdit']);
            Route::get('delete/{id}', [UserController::class, 'userDelete']);
            Route::get('admin_account', [UserController::class, 'adminDetail']);
        });

        Route::prefix('color_prediction')->group(function () {
            Route::post('create', [ColorPredictionController::class, 'create']);
            Route::post('end_game', [ColorPredictionController::class, 'endGame']);
            Route::get('history', [ColorPredictionController::class, 'history']);
        });

        Route::prefix('number_prediction')->group(function () {
            Route::post('create', [NumberPredictionController::class, 'create']);
            Route::post('end_game', [NumberPredictionController::class, 'endGame']);
            Route::get('history', [NumberPredictionController::class, 'history']);
        });

        Route::prefix('game')->group(function () {
            Route::get('last_created', [GamePredictionController::class, 'getGame']);
            Route::get('history', [GamePredictionController::class, 'getHistory']);
        });

        Route::prefix('wallet')->group(function () {
            Route::post('add', [WalletController::class, 'add']);
            Route::get('detail', [WalletController::class, 'detail']);
            Route::get('reference-detail', [WalletController::class, 'referenceDetail']);
        });

        Route::prefix('payment')->group(function () {
            Route::get('detail/{id}', [PaymentController::class, 'detail']);
            Route::get('history', [PaymentController::class, 'paymentHistory']);
        });

        Route::prefix('withdraw')->group(function () {
            Route::post('add', [WithdrawController::class, 'add']);
            Route::get('history', [WithdrawController::class, 'history']);
        });

        Route::prefix('contact')->group(function () {
            Route::post('add', [ContactUsController::class, 'create']);
            Route::get('detail/{id}', [ContactUsController::class, 'detail']);
            Route::get('list', [ContactUsController::class, 'list']);
        });

        Route::post('logout', [UserController::class, 'logout']);
    });
});
