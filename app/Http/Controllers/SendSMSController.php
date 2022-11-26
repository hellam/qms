<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SmsQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSMSController extends Controller
{

    public static function sendSms($token, $text, $settings, $from_call)
    {
//        Log::info('Sending SMS message');
        if (strpos($settings->sms_url, '$phone$') !== false && strpos($settings->sms_url, '$text$') !== false) {
            $text = '';
            if ($from_call == 'issue_token') {
                $search = array('$token_number$', '$service_name$', '$date$', '$position$');
                $replace = array($token->token_number, $token->service->name, Carbon::parse($token->created_at)->timezone($settings->timezone)->toDateString(), $token->position);
                $text = str_replace($search, $replace, $token->service->optin_message_format);
            } else if ($from_call == 'status_message') {
                $search = array('$token_number$', '$service_name$', '$position$');
                $replace = array($token->token_number, $token->service->name, $token->position);
                $text = str_replace($search, $replace, $token->service->status_message_format);
            } else if ($from_call == 'call_next' || $from_call == 'noshow' || $from_call == 'served') {
                $search = array('$token_number$', '$service_name$', '$date$', '$counter_name$');
                $replace = array($token->token_number, $token->service->name, Carbon::parse($token->created_at)->timezone($settings->timezone)->toDateString(), $token->call->counter->name);
                if ($from_call == 'call_next') $text = str_replace($search, $replace, $token->service->call_message_format);
                else if ($from_call == 'noshow') $text = str_replace($search, $replace, $token->service->noshow_message_format);
                else if ($from_call == 'served') $text = str_replace($search, $replace, $token->service->completed_message_format);
            }
//            Log::info('Calling sms service');
            $text = urlencode($text);
            $search = array('$phone$', '$text$');
            $replace = array($token->phone, $text);
            $url = str_replace($search, $replace, $settings->sms_url);
            try {
                SmsQueue::create([
                    'phone' => $token->phone,
                    'sms' => $text,
                    'from' => 'KUSH BANK',
                    ]);
//                $response = Http::get($url);
//                Log::info($url);
            } catch (\Exception $e) {
            }
        }
    }
}
