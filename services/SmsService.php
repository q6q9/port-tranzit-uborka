<?php

namespace app\services;

use app\models\SmsCodes;
use yii\base\InvalidConfigException;
use yii\base\Model;

class SmsService extends Model
{
    /**
     * @var string
     */
    public $api_url;

    /**
     * @var string
     */
    public $api_user;

    /**
     * @var string
     */
    public $api_sender;

    /**
     * @var string
     */
    public $api_password;

    public function __construct($config = [])
    {
        $this->api_url = getenv('SMS_API_URL');
        $this->api_user = getenv('SMS_API_USER');
        $this->api_sender = getenv('SMS_API_SENDER');
        $this->api_password = getenv('SMS_API_PASSWORD');
        parent::__construct($config);
    }

    /**
     * @param $phone
     * @param $code
     * @return bool
     */
    public static function checkCode($phone, $code)
    {
        $phone = mb_ereg_replace('[^0-9]', '', $phone);

        $smsCode = SmsCodes::findOne(
            ['phone' => $phone, 'code' => $code, 'introduced_at' => null]
        );

        if (!$smsCode) {
            return false;
        }

        $smsCode->introduced_at = date('Y-m-d H:i:s');
        $smsCode->update(false);

        return true;
    }

    public function sendGeneratedCode($phone)
    {
        if (
            empty($this->api_url)
            || empty($this->api_user)
            || empty($this->api_sender)
            || empty($this->api_password)
        ) {
            throw new InvalidConfigException('empty config sms');
        }

        $phone = mb_ereg_replace('[^0-9]', '', $phone);

        $smsCode = new SmsCodes();
        $smsCode->phone = $phone;
        $smsCode->code = rand(1000, 9999);
        $smsCode->created_at = date('Y-m-d H:i:s');

        $smsCode->save(false);

//        $client = new \yii\httpclient\Client();
//        $response = $client->createRequest()
//            ->setMethod('GET')
//            ->setUrl($this->api_url)
//            ->setData([
//                'user' => $this->api_user,
//                'pwd' => $this->api_password,
//                'sadr' => $this->api_sender,
//                'dadr' => $phone,
//                'text' => 'Код подтверждения: ' . $smsCode->code,
//            ])
//            ->send();
//
//        $smsCode->api_response = $response->content;
//        $smsCode->update(false);
//
//        if (!$response->isOk) {
//            throw new \yii\web\ServerErrorHttpException('Error sms sending');
//        }
//
//        if (!empty(mb_ereg_replace('[0-9]+', '', $response->content))) {
//            throw new \yii\web\ServerErrorHttpException('Error sms sending');
//        }
    }
}