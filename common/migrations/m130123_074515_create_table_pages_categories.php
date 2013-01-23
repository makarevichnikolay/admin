<?php

class m130123_074515_create_table_pages_categories extends CDbMigration
{
	public function up()
	{
        $this->createTable('pages_categories', array(
            'id' => 'pk',
            'page_id' => 'integer UNSIGNED NOT NULL',
            'category_id' => 'integer UNSIGNED NOT NULL',
        ));
        $this->createIndex('page_id', 'pages_categories', 'page_id');
        $this->createIndex('category_id', 'pages_categories', 'category_id');
	}

	public function down()
	{
		echo "m130123_074515_create_table_pages_categories does not support migration down.\n";
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