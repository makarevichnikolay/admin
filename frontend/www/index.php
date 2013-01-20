<?php
//$start = microtime(true);
$global_config		= require(dirname(__FILE__).'/../../common/config/global.php');
$web_config			= require(dirname(__FILE__).'/../../common/config/web.php');

$application_config	= require(dirname(__FILE__).'/../config/application.php');
$local_config		= require(dirname(__FILE__).'/../../common/config/local.php');

require(dirname(__FILE__) . '/../../common/yii-web.php');

$config	= CMap::mergeArray($global_config, $web_config);
$config = CMap::mergeArray($config, $application_config);
$config = CMap::mergeArray($config, $local_config);
//echo '<pre>';
//print_r($config);die;
//echo '</pre>';
Yii::$classMap=array(
   'IURLRule'=>dirname(__FILE__) . '/../../common/components/IURLRule.php', 
   // 'URLRule'=>dirname(__FILE__).'/../components/URLRule.php',
);

$app = Yii::createFWebApplication($config);
//echo   't:'. (microtime(true) - $start);
$app->run();
