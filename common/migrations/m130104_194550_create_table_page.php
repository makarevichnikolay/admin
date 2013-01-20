<?php

class m130104_194550_create_table_page extends CDbMigration
{
	public function up()
	{
		$this->createTable('pages', array(
            'id' => 'pk',
            'type_id'=>'integer',
            'url' => 'string NOT NULL',
            'title' => 'string NOT NULL',
            'keywords' => 'string NOT NULL',
            'description' => 'string NOT NULL',
            'content' => 'text NOT NULL',
            'publish'=> 'boolean NOT NULL',
        ));

		$this->createIndex('url', 'pages', 'url', true);
        $this->createIndex('type_id', 'pages', 'type_id');
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