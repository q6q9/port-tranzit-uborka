<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "surveys".
 *
 * @property int $id
 * @property string $phone
 * @property string|null $code
 * @property string $type
 * @property string $auto
 * @property int $district_id
 * @property int|null $price_novorossiysk
 * @property int|null $price_azov
 * @property int|null $price_volna
 * @property int|null $price_0_10
 * @property int|null $price_10_20
 * @property int|null $price_20_40
 * @property int|null $price_40_60
 * @property int|null $price_60_80
 * @property int|null $price_80_100
 *
 * @property Districts $district
 */
class Surveys extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'surveys';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'type', 'auto', 'district_id'], 'required'],
            [['district_id', 'price_novorossiysk', 'price_azov', 'price_volna', 'price_0_10', 'price_10_20', 'price_20_40', 'price_40_60', 'price_60_80', 'price_80_100'], 'integer'],
            [['phone', 'code', 'type', 'auto'], 'string', 'max' => 255],
            [['phone'], 'unique'],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'code' => 'Code',
            'type' => 'Type',
            'auto' => 'Auto',
            'district_id' => 'District ID',
            'price_novorossiysk' => 'Price Novorossiysk',
            'price_azov' => 'Price Azov',
            'price_volna' => 'Price Volna',
            'price_0_10' => 'Price  0  10',
            'price_10_20' => 'Price  10  20',
            'price_20_40' => 'Price  20  40',
            'price_40_60' => 'Price  40  60',
            'price_60_80' => 'Price  60  80',
            'price_80_100' => 'Price  80  100',
        ];
    }

    /**
     * Gets query for [[District]].
     *
     * @return ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }
}
