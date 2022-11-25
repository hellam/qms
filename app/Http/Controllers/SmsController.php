<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\PhoneNumber;

class SmsController extends Controller
{
    public function sendSms(Request $request): string
    {
        $phone_number = $this->phoneIsValid($request->phone);
        if ($phone_number['is_valid']) {
//            $this->talkTalkSendSMSAPI($phone_number['phone'],$request->text);
            return $this->talkTalkSendSMSAPI($phone_number['phone'],$request->text);;
        }
        return 'failed';
    }

    public function talkTalkSendSMSAPI($phone, $text)
    {
        $credentials = base64_encode('x1PADERMsF' . 'bwh607GfBcOCx9vXMNFeEp5snDUVAPlJ');
        return Http::withHeaders([
            'apiKey' => $credentials,
        ])->post('https://api.talktalkltd.com/api/v1/sms/send', [
            'from' => 'KUSH BANK',
            'to' => $phone,
            'message' => $text,
        ]);
    }

    public function phoneIsValid($phone): array
    {
        $is_valid = true;
//        $is_valid = preg_match('/^(\+)?[0-9]{12}$/', $phone);
        $phone = PhoneNumber::make($phone, 'SS');

        if (!preg_match('/^[+][0-9]/', $phone)) {
            foreach (['SS', "KE", 'UG'] as $country) {
                $phone = PhoneNumber::make($phone, $country);
                if (preg_match('/^[+][0-9]/', $phone))
                    break;
            }
        }

        if (strlen($phone) > 10 && !preg_match('/^[+][0-9]/', $phone))
            $is_valid = false;

        return ['is_valid' => $is_valid, 'phone' => $phone];
    }
}
