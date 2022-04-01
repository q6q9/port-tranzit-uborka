<?php

namespace app\forms;

use app\models\Districts;
use app\services\SmsService;
use Yii;
use yii\base\Model;
use yii\web\Response;

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
        $number = $this->fromFourthForm->fromThirdForm->secondForm->firstForm->number;

        if (!$this->validate()) {
            $this->clearErrors();
            return $this->render();
        }

        $checkCode = $this->smsService->checkCode($this->fromFourthForm->phone, $this->code);
        if (!!$checkCode) {
            $this->addError('code', 'Incorrect code');
            return $this->render();
        }

//        return \Yii::$app->controller->render('finish');


        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->data = $this->attributes;
        Yii::$app->end(0);

        $nextForm = Yii::createObject([
            'class' => '',
            'secondForm' => $this,
        ]);
        $nextForm->load(Yii::$app->request->post());
        return $nextForm->run();
    }

    private function render()
    {
        /** @var Districts $district */
        $district = Districts::find()
            ->with('region')
            ->andWhere($this->fromFourthForm->fromThirdForm->secondForm->district_id)
            ->one();

        return Yii::$app->controller->render('from_fifth', [
            'form' => $this,
            'district' => $district,
        ]);
    }
}