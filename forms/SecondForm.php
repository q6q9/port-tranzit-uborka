<?php

namespace app\forms;

use app\models\Districts;
use app\models\Regions;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\Cookie;

class SecondForm extends Model
{
    const NUMBER = 2;

    public static $autoTypes = [
        'Сельхозник',
        'Бортовая сцепка',
        'Бортовой трал',
    ];

    public $auto;

    public $region;

    public $district_id;

    /**
     * @var FirstForm
     */
    public $firstForm;

    public function rules()
    {
        return [
            [['auto', 'region', 'district_id'], 'required'],
            [['auto'], 'in', 'range' => self::$autoTypes],
            [['district_id'], 'exist', 'targetClass' => Districts::class, 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    public function run()
    {
        if (!$this->validate() && empty($this->district_id) && empty($this->auto)) {
            $attributes = json_decode(
                    \Yii::$app->request->cookies->getValue('secondForm', ''),
                    true
                ) ?? [];
            $this->attributes = $attributes;
        }

        if (!$this->validate() || $this->firstForm->number == self::NUMBER) {
            $this->clearErrors();

            $regions = Regions::find()->all();


            if ($district = Districts::findOne($this->district_id)) {
                $districts = ArrayHelper::map($district->region->districts, 'id', 'name');
            }

            return \Yii::$app->controller->render('second', [
                'form' => $this,
                'regions' => ArrayHelper::map($regions, 'id', 'name'),
                'districts' => $districts ?? [],
                'cars' => array_combine(
                    self::$autoTypes,
                    self::$autoTypes
                )
            ]);
        }


        \Yii::$app->response->cookies->add(new Cookie([
            'name' => 'secondForm',
            'value' => json_encode($this->attributes),
            'expire' => time() + 356 * 12 * 24 * 60 * 60
        ]));

        $nextFormClass = $this->firstForm->type === FirstForm::FROM_TOK_ELEVATOR
            ? FromThirdForm::class
            : ToThirdForm::class;

        $nextForm = \Yii::createObject([
            'class' => $nextFormClass,
            'secondForm' => $this,
        ]);
        $nextForm->load(\Yii::$app->request->post());
        return $nextForm->run();
    }
}