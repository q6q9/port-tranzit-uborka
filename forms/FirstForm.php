<?php

namespace app\forms;

use yii\base\Model;
use yii\web\Cookie;

class FirstForm extends Model
{
    const TO_TOK_ELEVATOR = 'C поля на ток/элеватор';
    const FROM_TOK_ELEVATOR = 'С тока/элеватора в порт';

    const NUMBER = 1;

    public static $types = [
        self::TO_TOK_ELEVATOR => self::TO_TOK_ELEVATOR,
        self::FROM_TOK_ELEVATOR => self::FROM_TOK_ELEVATOR
    ];

    public $type;

    public $number;

    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'in', 'range' => array_keys(self::$types)]
        ];
    }

    public function run()
    {
        if (!$this->validate() && empty($this->type)) {
            $attributes = json_decode(
                \Yii::$app->request->cookies->getValue('firstForm', ''),
                true
            ) ?? [];
            $this->attributes = $attributes;
        }

        if (!$this->validate() || $this->number == self::NUMBER) {
            $this->clearErrors();
            return \Yii::$app->controller->render('first', [
                'form' => $this
            ]);
        }

        \Yii::$app->response->cookies->add(new Cookie([
            'name' => 'firstForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextForm = \Yii::createObject([
            'class' => SecondForm::class,
            'firstForm' => $this,
        ]);
        $nextForm->load(\Yii::$app->request->post());
        return $nextForm->run();
    }
}