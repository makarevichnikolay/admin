<?php


//date_default_timezone_set('Europe/Kiev');


return array(
    'sourceLanguage' => 'en',
    'language' => 'ru',
     'preload'=>array('less'),
	'import' => array(
        'common.models.*',
		'common.components.*',
	),

	'components' => array(
        'less'=>array(
            'class'=>'common.ext.less.components.LessCompiler',
        ),
		'bootstrap'=>array(
			'class'=>'common.ext.bootstrap.components.Bootstrap',
		),
		
	),

	'params' => array(       
		'sitePath' 	=> dirname(dirname(dirname(__FILE__))) . '/',
        'site'=> dirname(dirname(__DIR__)),
        'dataRelPath' => 'data/',
		'tempRelPath' => 'data/temp/',
		'dataUserPath' => 'data/users/',
        'defaultModule'=>'Pages'
       
	),

	'modules' => array(
		   'Pages'=>array(
                  'class' => 'common.modules.Pages.PagesModule',
		   	),
            'Menu'=>array(
               'class' => 'common.modules.Menu.MenuModule',
            ),
	),
);
