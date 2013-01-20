<?php

define('BASE_URL_REGEXP', '|/[^/]+?$|');

return array(
    'name'=>'Admin',
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'preload' => array(
		'bootstrap',
	),
    'import'=>array(
        'application.components.*',
    ),
	'components' => array(
		'errorHandler' => array(
			'errorAction' => 'Default/error',
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
                '/'=>'Default/index',
                'Pages/Types/<action:\w+>'=>'Pages/AdminPageTypes/<action>',
                'Pages/Types'=>'Pages/AdminPageTypes/index',
                'Pages/<action:\w+>'=>'Pages/AdminPages/<action>',
                'Pages'=>'Pages/AdminPages/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',

            ),
        ),
		
	)
);