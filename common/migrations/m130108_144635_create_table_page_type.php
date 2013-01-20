<?php

class m130108_144635_create_table_page_type extends CDbMigration
{
	public function up()
	{
        $this->createTable('page_types', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'module' => 'string NOT NULL',
            'controller' => 'string NOT NULL',
            'view' => 'string NOT NULL',
        ));
	}

	public function down()
	{
        $this->dropTable('page_types');
		echo "m130108_144635_create_table_page_type does not support migration down.\n";
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