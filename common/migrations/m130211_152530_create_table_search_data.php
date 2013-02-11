<?php

class m130211_152530_create_table_search_data extends CDbMigration
{
	public function up()
	{
        $this->createTable('search_data', array(
            'id' => 'pk',
            'word_id'=>'int UNSIGNED NOT NULL',
            'model_id'=>'int UNSIGNED NOT NULL',
            'item_id'=>'int UNSIGNED NOT NULL',
            'count'=> 'int UNSIGNED NOT NULL',
        ));

        $this->createIndex('word_id', 'search_data', 'word_id');
        $this->createIndex('item_id', 'search_data', 'item_id');
    }


	public function down()
	{
		echo "m130211_152530_create_table_search_data does not support migration down.\n";
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