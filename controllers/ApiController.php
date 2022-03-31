<?php

namespace app\controllers;

use app\models\Districts;
use yii\rest\Controller;

class ApiController extends Controller
{
    public function actionDistricts($id)
    {
        return Districts::findAll(['region_id' => $id]);
    }
}