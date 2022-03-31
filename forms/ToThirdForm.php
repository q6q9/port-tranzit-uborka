<?php

namespace app\forms;

use app\models\Districts;
use app\models\Regions;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class ToThirdForm extends Model
{
    const NUMBER = 3;

    public static $autoTypes = [
        'Сельхозник',
        'Бортовая сцепка',
        'Бортовой трал',
    ];

    public $number;

    public $auto;

    public $region;

    public $district;

    /**
     * @var FirstForm
     */
    public $firstForm;

    public function rules()
    {
        return [
            [['auto', 'region', 'district'], 'required'],
            [['auto'], 'in', 'range' => self::$autoTypes],
            [['region'], 'exist', 'targetClass' => Regions::class, 'targetAttribute' => ['region' => 'name']],
            [['district'], 'exist', 'targetClass' => Districts::class, 'targetAttribute' => ['district' => 'name']],
        ];
    }

    public function run()
    {
        $cookies = \Yii::$app->response->cookies;

        if (!$this->validate() && empty($this->attributes)) {
            $attributes = json_decode($cookies->getValue('secondForm', []));
            $this->attributes = $attributes;
        }

        if ($this->validate() || $this->number == self::NUMBER) {
            $this->clearErrors();

            $regions = Regions::find()->all();


            return \Yii::$app->controller->render('second', [
                'form' => $this,
                'regions' => ArrayHelper::map($regions, 'id', 'name'),
                'cars' => array_combine(
                    self::$autoTypes,
                    self::$autoTypes
                )
            ]);
        }

        $cookies->add(new Cookie([
            'name' => 'secondForm',
            'value' => json_encode($this->attributes),
        ]));

        $nextForm = \Yii::createObject([
            'class' => SecondForm::class,
            'secondForm' => $this,
            'number' => SecondForm::NUMBER
        ]);
        $nextForm->load(\Yii::$app->request->post());
        return $nextForm->run();
    }
}