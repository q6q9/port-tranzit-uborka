<?php

namespace app\forms;

use yii\base\Model;
use yii\web\Cookie;

class SecondForm extends Model
{
    const NUMBER = 2;

    public static $autoTypes = [
        'farmer' => 'Сельхозник',
        'sideHitch' => 'Бортовая сцепка',
        'sideTrawl' => 'Бортовой трал',
    ];

    public $number;

    public $auto;

    public $region;

    public $district;

    /**
     * @var FirstForm
     */
    public $firstForm;

    public function rules()
    {
        return [
            [['auto', 'region','district'], 'required'],
            [['auto'], 'in', 'range' => array_keys(self::$autoTypes)],
        ];
    }

    public function run()
    {
        $cookies = \Yii::$app->response->cookies;

        if (!$this->validate() && empty($this->attributes)) {
            $attributes = json_decode($cookies->getValue('firstForm', []));
            $this->attributes = $attributes;
        }

        if ($this->validate() || $this->number == self::NUMBER) {
            $this->clearErrors();
            return \Yii::$app->controller->render('second', [
                'form' => $this
            ]);
        }

//        $cookies->add(new Cookie([
//            'name' => 'firstForm',
//            'value' => json_encode($this->attributes),
//        ]));
//
//        $nextForm = \Yii::createObject([
//            'class' => SecondForm::class,
//            'firstForm' => $this,
//            'number' => SecondForm::NUMBER
//        ]);
//        $nextForm->load(\Yii::$app->request->post());
//        return $nextForm->run();
    }
}