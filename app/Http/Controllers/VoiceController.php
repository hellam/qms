<?php

namespace App\Http\Controllers;

use App\CentralLogics\sms_module;
use App\Models\Messages;
use App\Models\Setting;
use App\Models\SmsQueue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;

class VoiceController extends Controller
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
    public function textToSpeach($lang, $text)
    {
//    $text = "Ticket number A10232 go to counter number 3";
//    $lang = "en";

        // MP3 filename generated using MD5 hash
        // Added things to prevent bug if you want same sentence in two different languages
        $file = md5(uniqid(time()));

        // Save MP3 file in folder with .mp3 extension
        $file = $file . ".mp3";

        //find if file exists
        $path = storage_path('app/public/audio/' . $file);
        $response = '';
        //if so, then unlink from storage
        if (!File::exists($path)) {
            $mp3 = 'data:audio/mp3;base64,'.base64_encode(file_get_contents(
                'https://translate.google.com/translate_tts?ie=UTF-8&client=tw-ob&q=' . urlencode($text) . '&tl=' . $lang));
            $response = $mp3;
        }

        return $response;
    }
}
