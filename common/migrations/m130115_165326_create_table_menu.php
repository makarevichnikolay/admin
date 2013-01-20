<?php

class m130115_165326_create_table_menu extends CDbMigration
{
	public function up()
	{
        $this->createTable('menu', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'show' => 'boolean NOT NULL',
        ));
	}

	public function down()
	{
		echo "m130115_165326_create_table_menu does not support migration down.\n";
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