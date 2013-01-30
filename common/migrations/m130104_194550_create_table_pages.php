<?php

class m130104_194550_create_table_pages extends CDbMigration
{
	public function up()
	{
		$this->createTable('pages', array(
            'id' => 'pk',
            'type_id'=>'int UNSIGNED NOT NULL',
            'title' => 'string NOT NULL',
            'keywords' => 'string NOT NULL',
            'description' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'date'=> 'datetime NOT NULL',
            'author_name'=> 'string NOT NULL',
            'author_image'=> 'string NOT NULL',
            'author_description'=> 'text NOT NULL',
            'content' => 'text NOT NULL',
            'main_image' => 'string NOT NULL',
            'visible'=> 'boolean NOT NULL',
            'visible_on_main'=>'boolean NOT NULL',
            'allow_comments'=> 'boolean NOT NULL',
            'user_id'=>'int UNSIGNED NOT NULL',
            'date_create'=>'datetime NOT NULL',
            'date_update'=>'datetime NOT NULL'
        ));

		$this->createIndex('url', 'pages', 'url', true);
        $this->createIndex('type_id', 'pages', 'type_id');
        $this->createIndex('date', 'pages', 'date');
	}

	public function down()
	{

		$this->dropTable('pages');
		echo "m130104_194550_create_table_page does not support migration down.\n";
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