<?php

class m130226_093655_create_table_banners extends CDbMigration
{
	public function up()
	{
        $this->createTable('banners', array(
            'id' => 'pk',
            'title' => 'string NOT NULL',
            'content' => 'text NOT NULL',
            'content2' => 'text NOT NULL',
        ));

	}

	public function down()
	{
		echo "m130226_093655_create_table_banners does not support migration down.\n";
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