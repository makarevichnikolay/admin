<?php

$global_config		= require(dirname(__FILE__).'/../common/config/global.php');
$application_config	= require(dirname(__FILE__).'/config/application.php');
$local_config		= require(dirname(__FILE__).'/../common/config/local.php');

require_once(YII_PATH.'/yii.php');

$config	= CMap::mergeArray($global_config, $application_config);
$config = CMap::mergeArray($config, $local_config);

Yii::setPathOfAlias('site', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('common', dirname(__FILE__) . '/../common/');

$app = Yii::createConsoleApplication($config);
$app->setParams(array(
	'dataPath' => Yii::app()->params['sitePath'] . Yii::app()->params['dataRelPath'],
	'tempPath' => Yii::app()->params['sitePath'] . Yii::app()->params['tempRelPath'],
));
$app->run();
