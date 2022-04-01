<?php

namespace app\controllers;

use app\models\Districts;
use app\services\SmsService;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ApiController extends Controller
{
    public function actionDistricts($id)
    {
        return Districts::findAll(['region_id' => $id]);
    }

    public function actionSendCode($phone)
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $service = new SmsService();
        $service->sendGeneratedCode($phone);
    }
}