<?php

class m130201_131001_create_table_users_role extends CDbMigration
{
	public function up()
	{
        $this->createTable('users_role',array(
            'id'=>'pk',
            'name'=>'string NOT NULL',
            'description'=>'string NOT NULL'
        ));

        $this->createIndex('name','users_role','name');
        $this->insert('users_role',array(
            'name'=>'user',
            'description'=>'Обычный пользователь'
        ));
        $this->insert('users_role',array(
            'name'=>'admin',
            'description'=>'Администратор'
        ));
	}

	public function down()
	{
		echo "m130201_131001_create_table_users_role does not support migration down.\n";
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