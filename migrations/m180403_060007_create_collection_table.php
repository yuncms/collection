<?php

use yuncms\db\Migration;

/**
 * Handles the creation of table `user_collection`.
 */
class m180403_060007_create_collection_table extends Migration
{
    /**
     * @var string The table name.
     */
    public $tableName = '{{%collections}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        /**
         * 用户收藏表
         */
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey()->comment('ID'),
            'user_id' => $this->unsignedInteger()->notNull()->comment('User Id'),
            'model_id' => $this->bigInteger()->notNull()->comment('Model Id'),
            'model_class' => $this->string()->notNull()->comment('Model Class'),
            'subject' => $this->string()->comment('Subject'),
            'created_at' => $this->unixTimestamp()->notNull()->comment('Created At'),
            'updated_at' => $this->unixTimestamp()->notNull()->comment('Updated At'),
        ], $tableOptions);

        $this->createIndex('collections_index', $this->tableName, ['user_id', 'model_id', 'model_class'], true);
        $this->addForeignKey('collections_fk_1', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
