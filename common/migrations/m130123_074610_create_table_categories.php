<?php

class m130123_074610_create_table_categories extends CDbMigration
{
	public function up()
	{
        $this->createTable('categories', array(
            'id' => 'pk',
            'parent_id'=>'integer UNSIGNED NOT NULL',
            'title' => 'string NOT NULL',
        ));
        $this->createIndex('parent_id', 'categories', 'parent_id');
        $this->insert('categories',array(
            'title'=>'Рубрика 1'
        ));
        $this->insert('categories',array(
            'title'=>'Рубрика 2'
        ));
        $this->insert('categories',array(
            'title'=>'Рубрика 3'
        ));
        $this->insert('categories',array(
            'title'=>'Рубрика 4'
        ));
        $this->insert('categories',array(
            'title'=>'ПодРубрика 11',
            'parent_id'=>1
        ));
        $this->insert('categories',array(
            'title'=>'ПодРубрика 12',
            'parent_id'=>2
        ));
        $this->insert('categories',array(
            'title'=>'ПодРубрика 11',
            'parent_id'=>1
        ));
	}


	public function down()
	{
		echo "m130123_074610_create_table_categories does not support migration down.\n";
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