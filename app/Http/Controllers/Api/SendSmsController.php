<?php

namespace App\Http\Controllers\Api;

use AlibabaCloud\SDK\Dysmsapi\V20170525\Models\SendSmsRequest;
use App\Http\Controllers\Controller;
use AlibabaCloud\SDK\Dysmsapi\V20170525\Dysmsapi;
use Darabonba\OpenApi\Models\Config;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;
use telesign\sdk\messaging\MessagingClient;

/**
 * Class SendSmsController
 * @package App\Http\Controllers\Api
 *
 * composer require alibabacloud/darabonba-openapi
 *  composer require alibabacloud/dysmsapi-20170525 2.0.9
 */
class SendSmsController extends Controller
{

    public function sendmessagebird()
    {
        $messagebird         = new \MessageBird\Client('ArDi0WK5S9ULeQzXC0V2bu7wE]');
        $message             = new \MessageBird\Objects\Message;
        $message->originator = '+86182xxx';
        $message->recipients = ['+86182xxx'];
        $message->body       = 'Hi! This is your first message';
        // $response            = $messagebird->messages->create($message);
        $list = $messagebird->messages->getList();
        print_r($list);
    }

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     *
     * baba521123456789
     * MM6fAGSje7CnXHa1g9XS9e24dloqBhy-bkQd4PdS
     */
    public function sendTwilio()
    {
        //SID PN628fbc75b877a66ecc5e4916366f9c62
        $account_sid = env('TWILIO_SID');
        $auth_token  = env('TWILIO_TOKEN');

        $twilio_number = "+xxx";

        $client = new Client($account_sid, $auth_token);
        $result = $client->messages->create(
        // Where to send a text message (your cell phone?)
            '+86xxxx',
            array(
                // 'from' => $twilio_number,
                'messagingServiceSid' => 'MG0693920bbd242908bd0b68b8a571a49b',
                'body' => 'This is Ok!'
            )
        );

        print_r($result->sid);
        exit();
    }

    /**
     * A123123afanxikeji
     */
    public function telesign()
    {
        $customer_id  = env('TELESIGN_CUSTOMER_ID');
        $api_key      = env('TELESIGN_API_KEY');
        $phone_number = "182xxxxxxxxx";
        $message      = "Dear, God bless you!";
        $message_type = "ARN";
        $messaging    = new MessagingClient($customer_id, $api_key);
        $response     = $messaging->message($phone_number, $message, $message_type);
        // $response     = $messaging->status("6600212DC33C0A689196574DFA34E330");

        print_r($response->json);
        exit();
    }


    public function sendSms(): \Illuminate\Http\JsonResponse
    {
        $sendResult = self::main();
        if ($sendResult === false) {
            return response()->json([
                'code' => -1,
                'msg'  => '??????????????????'
            ]);
        }

        return response()->json([
            'code' => 1,
            'msg'  => 'OK'
        ]);
    }

    /**
     * ??????AK&SK???????????????Client
     * @return Dysmsapi Client
     */
    public static function createClient()
    {
        $config = new Config([
            // ??????AccessKey ID
            "accessKeyId"     => env('SMS_ALIYUN_ACCESS_KEY_ID'),
            // ??????AccessKey Secret
            "accessKeySecret" => env('SMS_ALIYUN_ACCESS_KEY_SECRET')
        ]);
        // ???????????????
        $config->endpoint = "dysmsapi.aliyuncs.com"; // ??????
        // $config->endpoint = 'dysmsapi.ap-southeast-1.aliyuncs.com'; // ??????
        return new Dysmsapi($config);
    }

    public static function main(): bool
    {
        $client                = self::createClient();
        $sendSmsRequestRequest = new SendSmsRequest([
            'phoneNumbers'  => '18201197923',
            'signName'      => '?????????????????????',
            'templateCode'  => 'SMS_154950909',
            'templateParam' => '{"code":"8888"}'
        ]);

        // ????????????????????????????????? API ????????????
        $sendRequest = $client->sendSms($sendSmsRequestRequest);
        $code        = $sendRequest->body->code;
        if ($code != 'OK') {
            Log::error('??????????????????:' . $sendRequest->body->code . ', param:' . json_encode($sendSmsRequestRequest->toMap()));
            return false;
        }

        return true;
    }
}
