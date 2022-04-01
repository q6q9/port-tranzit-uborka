<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "sms_codes".
 *
 * @property int $id
 * @property string $code
 * @property string $phone
 * @property string $created_at
 * @property string|null $introduced_at
 * @property string|null $api_response
 */
class SmsCodes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sms_codes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'phone', 'created_at'], 'required'],
            [['created_at', 'introduced_at'], 'safe'],
            [['api_response'], 'string'],
            [['code', 'phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'phone' => 'Phone',
            'created_at' => 'Created At',
            'introduced_at' => 'Introduced At',
            'api_response' => 'Api Response',
        ];
    }
}
