<?php

class m130311_074909_create_table_static_pages extends CDbMigration
{
	public function up()
	{
        $this->createTable('static_pages', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'keywords_meta' => 'string NOT NULL',
            'description_meta' => 'string NOT NULL',
            'title_meta' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'date'=> 'datetime NOT NULL',
            'content' => 'text NOT NULL',
            'visible'=> 'boolean NOT NULL',
        ));

        $this->createIndex('url', 'static_pages', 'url', true);
	}

	public function down()
	{
		echo "m130311_074909_create_table_static_pages does not support migration down.\n";
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