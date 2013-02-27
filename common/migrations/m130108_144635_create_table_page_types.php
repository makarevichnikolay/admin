<?php

class m130108_144635_create_table_page_types extends CDbMigration
{
	public function up()
	{
       /* $this->createTable('page_types', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'module_id'=>'int UNSIGNED NOT NULL',
            'controller' => 'string NOT NULL',
            'action' => 'string NOT NULL',
            'view' => 'string NOT NULL',
        ));
        $this->createIndex('module_id', 'page_types', 'module_id');*/
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