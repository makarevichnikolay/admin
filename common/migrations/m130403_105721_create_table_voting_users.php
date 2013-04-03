<?php

class m130403_105721_create_table_voting_users extends CDbMigration
{
	public function up()
	{
        $this->createTable('voting_users', array(
            'id' => 'pk',
            'voting_id'=>'int UNSIGNED NOT NULL',
            'user_id'=>'int UNSIGNED NOT NULL',
            'voted'=>'boolean NOT NULL',
            'date'=> 'datetime NOT NULL',
        ));

        $this->createIndex('voting_id', 'voting_users', 'voting_id');
        $this->createIndex('user_id', 'voting_users', 'user_id');
	}

	public function down()
	{
		echo "m130403_105721_create_table_voting_users does not support migration down.\n";
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