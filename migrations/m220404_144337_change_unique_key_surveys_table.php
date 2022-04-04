<?php

use yii\db\Migration;

/**
 * Class m220404_144337_change_unique_key_surveys_table
 */
class m220404_144337_change_unique_key_surveys_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropIndex('phone', 'surveys');

        $this->createIndex(
            'surveys_UIDX_phone_and_type',
            'surveys',
            ['phone', 'type'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220404_144337_change_unique_key_surveys_table cannot be reverted.\n";

//        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220404_144337_change_unique_key_surveys_table cannot be reverted.\n";

        return false;
    }
    */
}
