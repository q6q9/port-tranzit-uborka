<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sms_codes}}`.
 */
class m220401_103107_create_sms_codes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sms_codes}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'introduced_at' => $this->dateTime(),
            'api_response' => $this->text()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sms_codes}}');
    }
}
