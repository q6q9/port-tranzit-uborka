<?php

namespace app\forms;

use app\models\Districts;
use Yii;
use yii\base\Model;
use yii\web\Cookie;

class ToFourthForm extends Model
{
    const NUMBER = 4;

    public $price_40_60;

    public $price_60_80;

    public $price_80_100;

    /**
     * @var ToThirdForm
     */
    public $toThirdForm;

    public function rules()
    {
        return [
            [['price_40_60', 'price_60_80', 'price_80_100'], 'required'],
            [['price_40_60', 'price_60_80', 'price_80_100'], 'integer'],
        ];
    }


    public function run()
    {
        if (
            !$this->validate()
            && empty($this->price_40_60)
            && empty($this->price_60_80)
            && empty($this->price_80_100)
        ) {
            $attributes = json_decode(
                    Yii::$app->request->cookies->getValue('toFourthForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        if (
            !$this->validate()
            || $this->toThirdForm->secondForm->firstForm->number == self::NUMBER
        ) {
            $this->clearErrors();

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere(['id' => $this->toThirdForm->secondForm->district_id])
                ->one();

            return Yii::$app->controller->render('to_fourth', [
                'form' => $this,
                'district' => $district,
            ]);
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'toFourthForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextForm = Yii::createObject([
            'class' => ToFifthForm::class,
            'toFourthForm' => $this,
        ]);
        $nextForm->load(Yii::$app->request->post());
        return $nextForm->run();
    }
}