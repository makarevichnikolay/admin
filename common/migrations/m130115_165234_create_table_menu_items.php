<?php

class m130115_165234_create_table_menu_items extends CDbMigration
{
	public function up()
	{
        $this->createTable('menu_items', array(
            'id' => 'pk',
            'menu_id' => 'integer NOT NULL',
            'parent_id' => 'integer NOT NULL',
            'position' => 'integer NOT NULL',
            'title' => 'string NOT NULL',
            'module_id' => 'integer NOT NULL',
            'url' => 'string NOT NULL',
            'show' => 'boolean NOT NULL',
        ));
        $this->createIndex('menu_id', 'menu_items', 'menu_id');
        $this->createIndex('parent_id', 'menu_items', 'parent_id');
	}

	public function down()
	{
		echo "m130115_165234_create_table_menu_items does not support migration down.\n";
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