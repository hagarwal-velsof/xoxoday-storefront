<?php

use Illuminate\Support\Facades\Route;
use Xoxoday\Storefront\Http\Controller\RedemptionController;

Route::group(['middleware' => ['web']], function () {

Route::get('/redemption', [RedemptionController::class, 'index']);

Route::post('/redemption', [RedemptionController::class, 'verifyLogin']);

Route::post('/sendOTP', [RedemptionController::class, 'sendOtp']);

Route::post('/addPoints', [RedemptionController::class, 'redeemPoints']);

Route::post('/logout', [RedemptionController::class, 'logout']);

Route::get('/confirmation',  [RedemptionController::class, 'confirmation']);
});
