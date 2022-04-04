<?php

namespace app\controllers;

use app\models\Districts;
use app\models\Surveys;
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
        $uniqueWithoutCode = Surveys::find()
            ->andWhere(['phone' => mb_ereg_replace('[^0-9]', '', $phone)])
            ->andWhere(['code' => null])
            ->exists();

        if (!$uniqueWithoutCode) {
            return;
        }

        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }
        $service = new SmsService();
        $service->sendGeneratedCode($phone);
    }
}