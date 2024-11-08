<?php

use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;


// 핸드폰번호 문자인증 (아이코드icode)
Route::post('/send-verification-code', [VerificationController::class, 'requestVerificationCode']);
Route::post('/verify-code', [VerificationController::class, 'verifyCode']);

