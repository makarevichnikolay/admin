<?php

define('YII_PATH', 'Z:/home/localhost/www/framework/');
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

return array(
    'preload'=>array('log'),

	'modules' => array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			//'ipFilters'=>array('127.0.0.1','::1'),
		),		
	),

	'components' => array(
        //'less'=>array(
           // 'forceCompile'=>YII_DEBUG,
      //  ),
     'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
			
				array(
					'class'=>'CWebLogRoute',
				),
				
			),
		),

        //'cache'=>array(
           // 'class'=>'system.caching.CFileCache',
      //  ),
		'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=yii_admin',
            'schemaCachingDuration'=>3600,
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
            'enableProfiling'=>true,
            'enableParamLogging'=>true
		),
		
	),
);