<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%districts}}`.
 */
class m220331_094317_create_districts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%districts}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'region_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'districts_FK_region_id',
            'districts',
            'region_id',
            'regions',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%districts}}');
    }
}
