<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 01.02.13
 * Time: 16:25
 * To change this template use File | Settings | File Templates.
 */
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'admin',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
);