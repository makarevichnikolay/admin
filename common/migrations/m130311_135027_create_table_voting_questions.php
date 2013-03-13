<?php

class m130311_135027_create_table_voting_questions extends CDbMigration
{
	public function up()
	{
        $this->createTable('voting_questions', array(
            'id' => 'pk',
            'voting_id'=>'int UNSIGNED NOT NULL',
            'title' => 'string NOT NULL',
            'image' => 'string NOT NULL',
            'visible'=> 'boolean NOT NULL',
            'date'=> 'datetime NOT NULL',
        ));

        $this->createIndex('voting_id', 'voting_questions', 'voting_id');
	}

	public function down()
	{
		echo "m130311_135027_create_table_voting_questions does not support migration down.\n";
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