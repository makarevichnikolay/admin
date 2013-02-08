<?php

class m130205_084048_create_table_comments extends CDbMigration
{
	public function up()
	{
        $this->createTable('comments', array(
            'id' => 'pk',
            'parent_id'=>'int UNSIGNED NOT NULL',
            'user_id'=>'int UNSIGNED NOT NULL',
            'page_id'=>'int UNSIGNED NOT NULL',
            'content' => 'text NOT NULL',
            'date_create'=>'datetime NOT NULL',
        ));

        $this->createIndex('user_id', 'comments', 'user_id');
        $this->createIndex('page_id', 'comments', 'page_id');
	}

	public function down()
	{
		echo "m130205_084048_create_table_comments does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}