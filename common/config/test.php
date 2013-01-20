<?php
return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'components'=>array(
		'fixture'=>array(
			'class'=>'system.test.CDbFixtureManager',
			'basePath'=>'../tests/fixtures',
		),
		// uncomment the following to use a MySQL database

	),
);

