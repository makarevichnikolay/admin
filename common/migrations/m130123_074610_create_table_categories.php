<?php

class m130123_074610_create_table_categories extends CDbMigration
{
	public function up()
	{
        $this->createTable('categories', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
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