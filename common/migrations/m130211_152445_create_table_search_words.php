<?php

class m130211_152445_create_table_search_words extends CDbMigration
{
	public function up()
	{
        $this->createTable('search_words', array(
            'id' => 'pk',
            'word'=>'string NOT NULL',
        ));

        $this->createIndex('word', 'search_words', 'word');
	}

	public function down()
	{
		echo "m130211_152445_create_table_search_words does not support migration down.\n";
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