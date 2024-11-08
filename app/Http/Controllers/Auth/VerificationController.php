<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SMSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    protected $smsService;

    public function __construct(SMSService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function requestVerificationCode(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^01[0-9]{8,9}$/',
        ]);

        $phoneNumber = $request->input('phone_number');
        // 6자리 인증번호 생성
        $verificationCode = random_int(100000, 999999);

        // SMS 발송
        $response = $this->smsService->sendVerificationCode($phoneNumber, $verificationCode);

        if ($response['success']) {
            Session::put('verification_code', $verificationCode);
            return response()->json(['message' => '인증번호가 전송되었습니다.']);
        } else {
            return response()->json(['message' => $response['message']], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|digits:6',
        ]);

        $inputCode = $request->input('verification_code');
        $sessionCode = Session::get('verification_code');

        if ($inputCode == $sessionCode) {
            Session::forget('verification_code');
            return response()->json(['message' => '인증이 완료되었습니다.']);
        } else {
            return response()->json(['message' => '인증번호가 잘못되었습니다.'], 400);
        }
    }
}
