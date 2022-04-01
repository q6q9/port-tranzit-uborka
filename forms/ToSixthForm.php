<?php

namespace app\forms;

use app\models\Districts;
use app\models\Surveys;
use app\services\SmsService;
use Yii;
use yii\base\Model;

class ToSixthForm extends Model
{
    const NUMBER = 6;

    public $code;

    /**
     * @var ToFifthForm
     */
    public $toFifthForm;

    /**
     * @var SmsService
     */
    public $smsService;

    public function __construct($config = [])
    {
        $this->smsService = new SmsService();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['code'], 'required'],
        ];
    }

    public function run()
    {
        if (!$this->validate()) {
            $this->clearErrors();
            return $this->render();
        }

        $checkCode = $this->smsService->checkCode($this->toFifthForm->phone, $this->code);
        if (!$checkCode) {
            $this->addError('code', 'Incorrect code');
            return $this->render();
        }

        $this->updateSurvey();

        foreach (Yii::$app->request->cookies->toArray() as $key => $value) {
            Yii::$app->response->cookies->remove($key);
        }

        return Yii::$app->controller->render('finish');
    }

    private function render()
    {
        /** @var Districts $district */
        $district = Districts::find()
            ->with('region')
            ->andWhere($this->toFifthForm->toFourthForm->toThirdForm->secondForm->district_id)
            ->one();

        return Yii::$app->controller->render('to_sixth', [
            'form' => $this,
            'district' => $district,
        ]);
    }

    private function updateSurvey()
    {
        $survey = Surveys::findOne([
            'phone' => mb_ereg_replace('[^0-9]', '', $this->toFifthForm->phone)
        ]);
        $survey->code = $this->code;
        $survey->update(false);
    }
}