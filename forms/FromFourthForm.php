<?php

namespace app\forms;

use app\models\Districts;
use app\models\Surveys;
use Yii;
use yii\base\Model;
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
                    Yii::$app->request->cookies->getValue('fromFourthForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        $number = $this->fromThirdForm->secondForm->firstForm->number;
        if (!$this->validate() || $number == self::NUMBER) {
            $this->clearErrors();

            if ($this->phone) {
                $this->uniquePhoneWithoutCode();
            }

            /** @var Districts $district */
            $district = Districts::find()
                ->with('region')
                ->andWhere($this->fromThirdForm->secondForm->district_id)
                ->one();

            return Yii::$app->controller->render('from_fourth', [
                'form' => $this,
                'district' => $district,
            ]);
        }


        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'fromFourthForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextForm = Yii::createObject([
            'class' => FromFifthForm::class,
            'fromFourthForm' => $this,
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

    private function saveSurvey()
    {
        $survey = new Surveys();
        $survey->phone = mb_ereg_replace('[^0-9]', '', $this->phone);
        $survey->type = $this->fromThirdForm->secondForm->firstForm->type;
        $survey->auto = $this->fromThirdForm->secondForm->auto;
        $survey->district_id = $this->fromThirdForm->secondForm->district_id;

        $survey->price_novorossiysk = $this->fromThirdForm->novorossiyskPrice;
        $survey->price_azov = $this->fromThirdForm->azovPrice;
        $survey->price_volna = $this->fromThirdForm->volnaPrice;

        $survey->save(false);
    }
}