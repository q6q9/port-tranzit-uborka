<?php

namespace app\forms;

use app\models\Districts;
use app\models\Surveys;
use app\services\SmsService;
use Yii;
use yii\base\Model;

class FromFifthForm extends Model
{
    const NUMBER = 5;

    public $code;

    /**
     * @var FromFourthForm
     */
    public $fromFourthForm;

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

        $checkCode = $this->smsService->checkCode($this->fromFourthForm->phone, $this->code);
        if (!$checkCode) {
            $this->addError('code', 'Неверный код');
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
            ->andWhere(['id' => $this->fromFourthForm->fromThirdForm->secondForm->district_id])
            ->one();

        return Yii::$app->controller->render('from_fifth', [
            'form' => $this,
            'district' => $district,
        ]);
    }

    private function updateSurvey()
    {
        $survey = Surveys::findOne([
            'phone' => mb_ereg_replace('[^0-9]', '', $this->fromFourthForm->phone),
            'type' => FirstForm::FROM_TOK_ELEVATOR
        ]);
        $survey->code = $this->code;
        $survey->update(false);
    }
}