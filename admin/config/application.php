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
        'common.ext.CArray',
        'common.ext.JToggleColumn.JToggleColumn',
        'common.ext.JToggleColumn.ToggleAction'
    ),
    'defaultController' => 'Default',

    'components' => array(
		'errorHandler' => array(
			'errorAction' => 'Default/error',
		),

        'file'=>array(
            'class'=>'common.ext.CFile',
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
                'Pages/Categories/<action:\w+>'=>'Pages/AdminCategories/<action>',
                'Pages/update/<id>'=>'Pages/adminPages/update',
                'Pages/Categories'=>'Pages/AdminCategories/index',
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