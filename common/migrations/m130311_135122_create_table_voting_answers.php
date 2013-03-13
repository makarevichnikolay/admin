<?php

class m130311_135122_create_table_voting_answers extends CDbMigration
{
	public function up()
	{
        $this->createTable('voting_answers', array(
            'id' => 'pk',
            'voting_id'=>'int UNSIGNED NOT NULL',
            'question_id'=>'int UNSIGNED NOT NULL',
            'count'=>'int UNSIGNED NOT NULL',
            'date'=> 'datetime NOT NULL',
        ));

        $this->createIndex('voting_id', 'voting_answers', 'voting_id');
        $this->createIndex('question_id', 'voting_answers', 'question_id');
	}

	public function down()
	{
		echo "m130311_135122_create_table_voting_answers does not support migration down.\n";
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