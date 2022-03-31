<?php

namespace app\forms;

use app\models\Districts;
use app\models\Regions;
use yii\base\Model;
use yii\web\Cookie;

class FromThirdForm extends Model
{
    const TO_TOK_ELEVATOR = 'C поля на ток/элеватор';
    const FROM_TOK_ELEVATOR = 'С тока/элеватора в порт';

    const NUMBER = 3;

    public $novorossiyskPrice;

    public $azovPrice;

    public $volnaPrice;

    /**
     * @var SecondForm
     */
    public $secondForm;

    public function rules()
    {
        return [
            [['novorossiyskPrice', 'azovPrice', 'volnaPrice'], 'required'],
            [['novorossiyskPrice', 'azovPrice', 'volnaPrice'], 'integer'],
        ];
    }


    public function run()
    {
        if (
            !$this->validate()
            && empty($this->novorossiyskPrice)
            && empty($this->azovPrice)
            && empty($this->volnaPrice)
        ) {
            $attributes = json_decode(
                    \Yii::$app->request->cookies->getValue('fromThirdForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
//            die(json_encode($attributes));
        }

        if (
            !$this->validate()
            || $this->secondForm->firstForm->number == self::NUMBER
        ) {
            $this->clearErrors();

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere($this->secondForm->district_id)
                ->one();

            return \Yii::$app->controller->render('from_third', [
                'form' => $this,
                'district' => $district,
            ]);
        }

        \Yii::$app->response->cookies->add(new Cookie([
            'name' => 'fromThirdForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        die(json_encode($this));
        $nextForm = \Yii::createObject([
            'class' => SecondForm::class,
            'firstForm' => $this,
        ]);
        $nextForm->load(\Yii::$app->request->post());
        return $nextForm->run();
    }
}