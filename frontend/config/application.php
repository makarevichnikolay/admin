<?php

define('BASE_URL_REGEXP', '|/[^/]+?/[^/]+?$|');


return array(

	'name'=>'Site',
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'language' => 'ru',
	'preload' => array('bootstrap'),
     
     'import' => array(
		'application.components.*',
         'common.modules.Search.models.SearchWords'
	),

	'components' => array(
		'errorHandler' => array(
			'errorAction' => '/Default/error',
		),
        'less'=>array(
            'forceCompile'=>true,
            'paths'=>array(
                'less/styles.less'=>'css/styles.css'
            ),
        ),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,			
			'rules'=>array(
				array(
                    'class' => 'URLRule',
                ),
                '/'=>'Default/index',
                'rss'=>'Rss/index',
                'Search'=>'Search/Search/Search',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

			),
		),
		
	),
);
