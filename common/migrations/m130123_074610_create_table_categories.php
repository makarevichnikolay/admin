<?php

class m130123_074610_create_table_categories extends CDbMigration
{
	public function safeUp()
	{
        $this->createTable('categories', array(
            'id' => 'pk',
            'parent_id'=>'integer UNSIGNED NOT NULL',
            'title' => 'string NOT NULL',
            'url' => 'string NOT NULL',
            'lastModified'=>'datetime NOT NULL'
        ));
        $this->createIndex('parent_id', 'categories', 'parent_id');
        $this->createIndex('url', 'categories', 'url', true);
        $this->insert('categories',array(
            'title'=>'Політика',
            'url'=>'s1'
        ));
        $this->insert('categories',array(
            'title'=>'Економіка',
            'url'=>'s2'
        ));
        $this->insert('categories',array(
            'title'=>'Суспільство',
            'url'=>'s3'
        ));
        $this->insert('categories',array(
            'title'=>'Культура',
            'url'=>'s4'
        ));
        $this->insert('categories',array(
            'title'=>'Спорт',
            'url'=>'s5'
        ));
        $this->insert('categories',array(
            'title'=>'Фоторепортаж',
            'url'=>'s6'
        ));
        $this->insert('categories',array(
            'title'=>'Відео новини',
            'url'=>'s7'
        ));
        $this->insert('categories',array(
            'title'=>'Ти репортер',
            'url'=>'s8'
        ));
        $this->insert('categories',array(
            'title'=>'Інтерв’ю',
            'url'=>'s9'
        ));
        $this->insert('categories',array(
            'title'=>'Досьє',
            'url'=>'s10'
        ));
        $this->insert('categories',array(
            'title'=>'Афіша',
            'url'=>'s11'
        ));
        $this->insert('categories',array(
            'title'=>'Про місто',
            'url'=>'s12'
        ));
        $this->insert('categories',array(
            'title'=>'Куди піти',
            'url'=>'s13'
        ));
	}


	public function down()
	{
		echo "m130123_074610_create_table_categories does not support migration down.\n";
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