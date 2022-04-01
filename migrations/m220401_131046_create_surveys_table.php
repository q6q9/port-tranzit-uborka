<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%surveys}}`.
 */
class m220401_131046_create_surveys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%surveys}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string()->notNull()->unique(),
            'code' => $this->string(),

            'type' => $this->string()->notNull(),
            'auto' => $this->string()->notNull(),
            'district_id' => $this->integer()->notNull(),

            'price_novorossiysk' => $this->integer(),
            'price_azov' => $this->integer(),
            'price_volna' => $this->integer(),


            'price_0_10' => $this->integer(),
            'price_10_20' => $this->integer(),
            'price_20_40' => $this->integer(),
            'price_40_60' => $this->integer(),
            'price_60_80' => $this->integer(),
            'price_80_100' => $this->integer(),
        ]);

        $this->addForeignKey(
            'surveys_FK_district_id',
            'surveys',
            'district_id',
            'districts',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%surveys}}');
    }
}
