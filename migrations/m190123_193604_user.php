<?php

use yii\db\Migration;

/**
 * Class m190123_193604_user
 */
class m190123_193604_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
                'id' => $this->primaryKey(),
                'username' => $this->string()->notNull(),
                'password_hash' => $this->string()->notNull(),
                'auth_key' => $this->string(),
                'creator_id' => $this->integer()->notNull(),
                'updater_id' => $this->integer(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer(),
                
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190123_193604_user cannot be reverted.\n";

        return false;
    }
    */
}
