<?php


//date_default_timezone_set('Europe/Kiev');


return array(
    'sourceLanguage' => 'en',
    'language' => 'ru',
     'preload'=>array('less'),
	'import' => array(
        'common.models.*',
		'common.components.*',
        'common.modules.Users.models.*'
	),

	'components' => array(
        'morphy'=>array(
            'class'=>'common.ext.phpMorphy.RMorphy',
        ),
        'less'=>array(
            'class'=>'common.ext.less.components.LessCompiler',
        ),
		'bootstrap'=>array(
			'class'=>'common.ext.bootstrap.components.Bootstrap',
		),
        'user' => array(
            'class' => 'common.components.WebUser',
            'allowAutoLogin' => true,
            'autoRenewCookie' => true,
            //'loginUrl' => array('Users/Users/login'),
        ),
        'authManager' => array(
            'class' => 'common.components.PhpAuthManager',
            'defaultRoles' => array('guest'),
        ),
		
	),

	'params' => array(       
		'sitePath' 	=> dirname(dirname(dirname(__FILE__))) . '/',
        'site'=> dirname(dirname(__DIR__)),
        'dataRelPath' => 'data/',
		'tempRelPath' => 'data/temp/',
		'dataUserPath' => 'data/users/',
        'defaultModule'=>'Pages',
        'Pages'=>array(
            'main_image'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'dimensions' => array(
                    'thumb'	=> array('width'=>200, 'height'=>160),
                    'large'	=> array('width'=>600, 'height'=>800),
                ),
            ),
            'author_image'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'dimensions' => array(
                    'thumb'	=> array('width'=>300, 'height'=>200),
                    'large'	=> array('width'=>600, 'height'=>800),
                ),
            ),
            'images'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'maxCount'=>16,
                'dimensions' => array(
                    'thumb'	=> array('width'=>300, 'height'=>200),
                    'large'	=> array('width'=>600, 'height'=>800),
                ),
            )
        ),
       
	),

	'modules' => array(
		   'Pages'=>array(
                  'class' => 'common.modules.Pages.PagesModule',
		   	),
            'Menu'=>array(
               'class' => 'common.modules.Menu.MenuModule',
            ),
           'Users'=>array(
               'class' => 'common.modules.Users.UsersModule',
           ),
           'Comments'=>array(
               'class' => 'common.modules.Comments.CommentsModule'
           ),
           'Search'=>array(
               'class' => 'common.modules.Search.SearchModule'
           ),
	),
);
