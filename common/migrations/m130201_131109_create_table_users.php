<?php

class m130201_131109_create_table_users extends CDbMigration
{
	public function up()
	{
        $this->createTable('users',array(
            'id'=>'pk',
            'login'=>'string NOT NULL',
            'password'=>'string NOT NULL',
            'nickname'=>'string NOT NULL',
            'first_name'=>'string NOT NULL',
            'last_name'=>'string NOT NULL',
            'phone'=>'string NOT NULL',
            'ip'=>'string NOT NULL',
            'role_id'=>'int UNSIGNED NOT NULL ',
            'last_visited'=>'datetime NOT NULL',
            'baned'=>'boolean NOT NULL',
        ));
	}

	public function down()
	{
		echo "m130201_131109_create_table_users does not support migration down.\n";
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