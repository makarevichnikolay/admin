<?php

class m130124_115255_pages_images extends CDbMigration
{
	public function up()
	{
        $this->createTable('pages_images', array(
            'id' => 'pk',
            'page_id'=>'int UNSIGNED NOT NULL',
            'title' =>'string NOT NULL',
            'file_name'=>'string NOT NULL',
        ));

        $this->createIndex('page_id', 'pages_images', 'page_id');
	}

	public function down()
	{
		echo "m130124_115255_pages_images does not support migration down.\n";
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