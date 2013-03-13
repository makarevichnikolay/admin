<?php

class m130311_134701_create_table_voting extends CDbMigration
{
	public function up()
	{
        $this->createTable('voting', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'question_vote' => 'string NOT NULL',
            'date'=> 'datetime NOT NULL',
            'count_vote'=>'int UNSIGNED NOT NULL',
            'visible'=> 'boolean NOT NULL',
        ));

	}

	public function down()
	{
		echo "m130311_134701_create_table_voting does not support migration down.\n";
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