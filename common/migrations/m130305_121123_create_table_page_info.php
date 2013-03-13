<?php

class m130305_121123_create_table_page_info extends CDbMigration
{
	public function up()
	{
        $this->createTable('page_info', array(
            'id' => 'pk',
            'page_id'=>'int UNSIGNED NOT NULL',
            'count_comments'=>'int UNSIGNED NOT NULL',
            'count_visited'=>'int UNSIGNED NOT NULL',

        ));

        $this->createIndex('page_id', 'page_info', 'page_id',true);
	}

	public function down()
	{
		echo "m130305_121123_create_table_page_info does not support migration down.\n";
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