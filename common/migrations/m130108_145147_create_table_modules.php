<?php

class m130108_145147_create_table_modules extends CDbMigration
{
	public function up()
	{
        $this->createTable('modules', array(
            'id' => 'pk',
            'url' => 'string NOT NULL',
            'title' => 'string NOT NULL',
            'module' => 'string NOT NULL',
            'controller' => 'string NOT NULL',
            'action' => 'string NOT NULL',
            'view' => 'string NOT NULL',
        ));
        $this->createIndex('url', 'modules', 'url', true);
	}

	public function down()
	{
		echo "m130108_145147_create_table_modules does not support migration down.\n";
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