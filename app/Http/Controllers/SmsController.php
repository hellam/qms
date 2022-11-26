<?php

namespace App\Http\Controllers;

use App\CentralLogics\sms_module;
use App\Models\Messages;
use App\Models\Setting;
use App\Models\SmsQueue;
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
            return $this->talkTalkSendSMSAPI($phone_number['phone'], $request->text);;
        }
        return 'failed';
    }

    public function smppSendQueued(): string
    {
        $outbox = SmsQueue::where('sent', 0)
            ->whereDate('created_at', '>=', Carbon::now()->toDateString())
            ->limit(1000)
            ->get();

        foreach ($outbox as $sms) {
            $phone_number = $this->phoneIsValid($sms->to);
            if ($phone_number['is_valid']) {
                $sms->sent = 1;
                $sms->update();
                $this->talkTalkSendSMSAPI($phone_number['phone'], $sms->sms, $sms->from);
            }else{
                $sms->sent = 2;
                $sms->update();
            }
        }
        //get queued sms

        return "success";
    }

    public function talkTalkSendSMSAPI($phone, $text, $from = 'KUSH BANK')
    {
        $credentials = base64_encode('x1PADERMsF' . 'bwh607GfBcOCx9vXMNFeEp5snDUVAPlJ');
        return Http::withHeaders([
            'apiKey' => $credentials,
        ])->post('https://api.talktalkltd.com/api/v1/sms/send', [
            'from' => $from,
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
