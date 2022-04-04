<?php

namespace app\forms;

use app\models\Districts;
use app\models\Surveys;
use Yii;
use yii\base\Model;
use yii\web\Cookie;

class ToFifthForm extends Model
{
    const NUMBER = 5;

    public $phone;

    /**
     * @var ToFourthForm
     */
    public $toFourthForm;

    public function rules()
    {
        return [
            [['phone'], 'required'],
            [['phone'], 'uniquePhoneWithoutCode'],
        ];
    }

    public function run()
    {
        if ($this->phone && $this->uniquePhone()) {
            $this->saveSurvey();
        }

        if (!$this->validate() && empty($this->phone)) {
            $attributes = json_decode(
                    Yii::$app->request->cookies->getValue('toFifthForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        $number = $this->toFourthForm->toThirdForm->secondForm->firstForm->number;
        if (!$this->validate() || $number == self::NUMBER) {
            $this->clearErrors();

            if ($this->phone) {
                $this->uniquePhoneWithoutCode();
            }

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere($this->toFourthForm->toThirdForm->secondForm->district_id)
                ->one();

            return Yii::$app->controller->render('to_fifth', [
                'form' => $this,
                'district' => $district,
            ]);
        }


        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'toFifthForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextForm = Yii::createObject([
            'class' => ToSixthForm::class,
            'toFifthForm' => $this,
        ]);
        $nextForm->load(Yii::$app->request->post());
        return $nextForm->run();
    }

    public function uniquePhone()
    {
        return !Surveys::find()
            ->andWhere(['phone' => mb_ereg_replace('[^0-9]', '', $this->phone)])
            ->exists();
    }

    private function saveSurvey()
    {
        $survey = new Surveys();
        $survey->phone = mb_ereg_replace('[^0-9]', '', $this->phone);
        $survey->type = $this->toFourthForm->toThirdForm->secondForm->firstForm->type;
        $survey->auto = $this->toFourthForm->toThirdForm->secondForm->auto;
        $survey->district_id = $this->toFourthForm->toThirdForm->secondForm->district_id;

        $survey->price_0_10 = $this->toFourthForm->toThirdForm->price_0_10;
        $survey->price_10_20 = $this->toFourthForm->toThirdForm->price_10_20;
        $survey->price_20_40 = $this->toFourthForm->toThirdForm->price_20_40;

        $survey->price_40_60 = $this->toFourthForm->price_40_60;
        $survey->price_60_80 = $this->toFourthForm->price_60_80;
        $survey->price_80_100 = $this->toFourthForm->price_80_100;

        $survey->save(false);
    }

    public function uniquePhoneWithoutCode()
    {
        $uniqueWithoutCode = Surveys::find()
            ->andWhere(['phone' => mb_ereg_replace('[^0-9]', '', $this->phone)])
            ->andWhere(['code' => null])
            ->exists();

        if (!$uniqueWithoutCode) {
            $this->addError('phone', 'Этот телефон уже участвовал');
        }

        return $uniqueWithoutCode;
    }
}