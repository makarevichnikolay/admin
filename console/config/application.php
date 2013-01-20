<?php

return array(
    'language' => 'en',
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Console application',
	'import' => array(
		'system.cli.commands.*',
		'common.migrations.lib.*',
	),
	'preload'=>array('log'),
	// application components
	'components' => array(
		'log' => array(
			'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'info, error, warning',
				),

			),
		),
	),

	'commandMap' => array(
		'migrate' => array(
		//	'class'=>'common.components.RecursiveMigrateCommand',//'system.cli.commands.MigrateCommand',
            'class'=>'system.cli.commands.MigrateCommand',
		//	'migrationTable' => '_migration',
			'migrationPath' => 'common.migrations',
         //   'modulePaths' => array(
             //   'emailer'      => 'common.modules.YOnixCommon.Emailer.migrations',
             //   'YOnixUser'      => 'common.modules.YOnixUser.migrations',
            //),
		),
       // 'sendemailsubscribe' => array(
         //   'class'=>'common.modules.YOnixCommon.Emailer.commands.SendEmailSubscribeCommand',
       // ),
	),
);
