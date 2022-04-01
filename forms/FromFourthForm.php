<?php

namespace app\forms;

use app\models\Districts;
use app\models\Regions;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class FromFourthForm extends Model
{
    const NUMBER = 4;

    public $phone;

    /**
     * @var FromThirdForm
     */
    public $fromThirdForm;

    public function rules()
    {
        return [
            [['phone'], 'required'],
        ];
    }

    public function run()
    {
        if (!$this->validate() && empty($phone)) {
            $attributes = json_decode(
                    \Yii::$app->request->cookies->getValue('fromFourthForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        $number = $this->fromThirdForm->secondForm->firstForm->number;
        if (!$this->validate() || $number == self::NUMBER) {
            $this->clearErrors();

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere($this->fromThirdForm->secondForm->district_id)
                ->one();

            return \Yii::$app->controller->render('from_fourth', [
                'form' => $this,
                'district' => $district,
            ]);
        }


        \Yii::$app->response->cookies->add(new Cookie([
            'name' => 'fromFourthForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        die(json_encode($this->attributes));
        $nextForm = \Yii::createObject([
            'class' => $nextFormClass,
            'secondForm' => $this,
        ]);
        $nextForm->load(\Yii::$app->request->post());
        return $nextForm->run();
    }
}