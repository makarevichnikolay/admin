<?php

$global_config		= require(dirname(__FILE__).'/../../common/config/global.php');
$web_config			= require(dirname(__FILE__).'/../../common/config/web.php');

$application_config	= require(dirname(__FILE__).'/../config/application.php');
$local_config		= require(dirname(__FILE__).'/../../common/config/local.php');

require(dirname(__FILE__) . '/../../common/yii-web.php');

$config	= CMap::mergeArray($global_config, $web_config);
$config = CMap::mergeArray($config, $application_config);
$config = CMap::mergeArray($config, $local_config);

$app = Yii::createFWebApplication($config);
$app->run();
