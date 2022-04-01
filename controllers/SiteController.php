<?php

namespace app\controllers;

use app\forms\FirstForm;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($number=1)
    {
//        if (isset($_SERVER['HTTP_COOKIE'])) {
//            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
//            foreach($cookies as $cookie) {
//                $parts = explode('=', $cookie);
//                $name = trim($parts[0]);
//                setcookie($name, '', time()-1000);
//                setcookie($name, '', time()-1000, '/');
//            }
//        }
        $form = new FirstForm(['number' => intval($number)]);
        $form->load(Yii::$app->request->post());
        return $form->run();
    }
}
