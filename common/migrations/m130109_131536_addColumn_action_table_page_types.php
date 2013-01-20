<?php

class m130109_131536_addColumn_action_table_page_types extends CDbMigration
{
	public function up()
	{
        $this->addColumn('page_types','action','string not null');
	}

	public function down()
	{
		echo "m130109_131536_addColumn_action_table_page_types does not support migration down.\n";
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