<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        echo $credentials = base64_encode('xag6nRrEZL' . '8avIEgM3mPdhuDTU49WZwzos6cFALxfe');;
//        $this->assertTrue(true);
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
}
