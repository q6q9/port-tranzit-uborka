<?php

namespace app\controllers;

use app\forms\FirstForm;
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

    public function actionSendCode($phone, $type)
    {
        if (!Yii::$app->request->isPost) {
            throw new BadRequestHttpException();
        }

        if (!in_array($type, FirstForm::$types)) {
            throw new BadRequestHttpException();
        }

        $notUniqueWithoutCode = Surveys::find()
            ->andWhere(['phone' => mb_ereg_replace('[^0-9]', '', $phone)])
            ->andWhere(['not', ['code' => null]])
            ->andWhere(['type' => $type])
            ->exists();

        if ($notUniqueWithoutCode) {
            return 'not unique';
        }

        $service = new SmsService();
        $service->sendGeneratedCode($phone);

        return 'success';
    }
}