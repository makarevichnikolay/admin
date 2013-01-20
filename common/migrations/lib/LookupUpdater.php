<?php

class LookupUpdater {

	/**
	 * @var CDbMigration 
	 */
	private $_migration;
	
	function __construct(CDbMigration $migration) {
		$this -> _migration = $migration;
	}
	
	function run() {
		$this->_migration->truncateTable(Lookup::TABLE);
		
		$position = 1;
		$this ->insert_lookup('Нет', Lookup::BOOLEAN, Lookup::BOOLEAN_FALSE, $position++,'');
		$this ->insert_lookup('Да', Lookup::BOOLEAN, Lookup::BOOLEAN_TRUE, $position++,'');
		
		$position = 1;
		$this->insert_lookup('Что? Где? Когда?', Tournament::TOURNAMENT_TYPE, Tournament::TYPE_CGK, $position++,'CHGK');
		$this->insert_lookup('Брэйн-ринг', Tournament::TOURNAMENT_TYPE, Tournament::TYPE_BR, $position++,'BR');
		$this->insert_lookup('Своя Игра', Tournament::TOURNAMENT_TYPE, Tournament::TYPE_SI, $position++,'SI');
		$this->insert_lookup('Эрудит-Квартет', Tournament::TOURNAMENT_TYPE, Tournament::TYPE_EK, $position++,'EK');

		$position = 1;
		$this->insert_lookup('Предстоящий', Tournament::TOURNAMENT_STATUS, Tournament::STATUS_NOT_START, $position++,'');
		$this->insert_lookup('Текущий', Tournament::TOURNAMENT_STATUS, Tournament::STATUS_CURRENT, $position++,'');
		$this->insert_lookup('Завершенный', Tournament::TOURNAMENT_STATUS, Tournament::STATUS_COMPLETED, $position++,'');

		$position = 1;
		$this->insert_lookup('Основная', Tournament::TOURNAMENT_CATEGORY, Tournament::CATEGORY_GENERAL, $position++,'general');
		$this->insert_lookup('Молодежь', Tournament::TOURNAMENT_CATEGORY, Tournament::CATEGORY_YOUTH, $position++,'youth');
		$this->insert_lookup('Школьники', Tournament::TOURNAMENT_CATEGORY, Tournament::CATEGORY_JUNIOR, $position++,'students');

        $position = 1;
		$this->insert_lookup('Турнир', Lookup::ANNOUNCE_TYPE, Announcement::TOURNAMENT, $position++,'');
		$this->insert_lookup('Решение правления', Lookup::ANNOUNCE_TYPE, Announcement::DECISION, $position++,'');
		$this->insert_lookup('Внутренняя новость', Lookup::ANNOUNCE_TYPE, Announcement::NEWS, $position++,'');

    }
	
	function insert_lookup($name, $type, $code, $position,$abbr) {
		$this->_migration->insert(Lookup::TABLE, array(
			'name' => $name,
			'type' => $type,
			'code' => $code,
			'position' => $position,
            'abbr'=>$abbr
		));
	}
}

?>
