<?php

namespace app\forms;

use app\models\Districts;
use Yii;
use yii\base\Model;
use yii\web\Cookie;

class ToThirdForm extends Model
{
    const NUMBER = 3;

    public $price_0_10;

    public $price_10_20;

    public $price_20_40;

    /**
     * @var SecondForm
     */
    public $secondForm;

    public function rules()
    {
        return [
            [['price_10_20', 'price_0_10', 'price_20_40'], 'required'],
            [['price_10_20', 'price_0_10', 'price_20_40'], 'integer'],
        ];
    }


    public function run()
    {
        if (
            !$this->validate()
            && empty($this->price_0_10)
            && empty($this->price_10_20)
            && empty($this->price_20_40)
        ) {
            $attributes = json_decode(
                    Yii::$app->request->cookies->getValue('toThirdForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        if (
            !$this->validate()
            || $this->secondForm->firstForm->number == self::NUMBER
        ) {
            $this->clearErrors();

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere(['id' => $this->secondForm->district_id])
                ->one();

            return Yii::$app->controller->render('to_third', [
                'form' => $this,
                'district' => $district,
            ]);
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'toThirdForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextForm = Yii::createObject([
            'class' => ToFourthForm::class,
            'toThirdForm' => $this,
        ]);
        $nextForm->load(Yii::$app->request->post());
        return $nextForm->run();
    }
}