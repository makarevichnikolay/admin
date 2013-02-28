<?php


//date_default_timezone_set('Europe/Kiev');


return array(
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'charset'=>'utf-8',
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
        'cache'=>array(
            'class'=>'system.caching.CFileCache',
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
            'redactor_image'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'dimensions' => array(
                    'thumb'	=> array('width'=>200, 'height'=>160,'type'=>3),
                    'thumb2'=> array('width'=>204, 'height'=>113,'type'=>4),
                    'large'	=> array('width'=>600, 'height'=>800,'type'=>3),
                ),
            ),
            'main_image'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'dimensions' => array(
                    'thumb'	=> array('width'=>200, 'height'=>160,'type'=>3),
                    'thumb2'=> array('width'=>204, 'height'=>113,'type'=>4),
                    'new-view'	=> array('width'=>360, 'height'=>204,'type'=>4),
                    'photo-new'	=> array('width'=>230, 'height'=>190,'type'=>3),
                    'large'	=> array('width'=>800, 'height'=>600,'type'=>3),
                ),
            ),
            'author_image'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'dimensions' => array(
                    'thumb'	=> array('width'=>50, 'height'=>50,'type'=>3),
                    //'large'	=> array('width'=>600, 'height'=>800),
                ),
            ),
            'images'=>array(
                'ext' => array('jpg', 'jpeg', 'png'),
                'maxSize'=>20 * 1024 * 1024,
                'maxCount'=>16,
                'dimensions' => array(
                    'thumb'	=> array('width'=>150, 'height'=>86,'type'=>4),
                    'large'	=> array('width'=>800, 'height'=>600,'type'=>4),
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
           'Banners'=>array(
              'class' => 'common.modules.Banners.BannersModule'
          ),
	),
);
