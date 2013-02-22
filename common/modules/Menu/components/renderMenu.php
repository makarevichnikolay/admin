<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 21.02.13
 * Time: 11:09
 * To change this template use File | Settings | File Templates.
 */
class renderMenu {

    static function getFrontendMenu($class = 'first',$limit=7,$offset=0){
        $Categories = Categories::model()->with(array('children'))->findAll(array(
            'condition'=>'parent_id=0',
            'order'=>'parent_id',
            'limit'=>$limit,
            'offset'=>$offset
        ));
        $menu = $aux  ='';
        $menu .= CHtml::openTag('ul',array('class'=>$class));

        if($class == 'first'){
            $aux = '&nbsp';
            $menu .= CHtml::openTag('li',array('class'=>'main-wrap','data-id'=>'main'));
            $menu .= CHtml::link('Головна',array('/Default/index'),array('class'=>'main-link'));
            $menu .= CHtml::closeTag('li').$aux;
        }
        foreach($Categories as $value){
            if($value->parent_id == 0){
                $menu .= CHtml::openTag('li',array('class'=>'main-wrap','data-id'=>$value->id));
                $menu .= CHtml::link($value->title,Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$value->id)),array('class'=>'main-link'));
                if(!empty($value->children)){
                    $menu .= CHtml::openTag('ul',array('class'=>'menu-inner'));
                    foreach($value->children as $val){
                        $menu .= CHtml::openTag('li',array('data-id'=>$val->id));
                        $menu .= CHtml::link($val->title,Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$val->id)));
                        $menu .= CHtml::closeTag('li');
                    }
                    $menu .= CHtml::closeTag('ul');
                }
                $menu .= CHtml::closeTag('li').$aux ;
            }
        }
        if($class == 'second'){
            $menu .= CHtml::openTag('li',array('class'=>'main-wrap'));
            $menu .= CHtml::link('Контакти','#',array('class'=>'main-link'));
            $menu .= CHtml::closeTag('li');
            $menu .= CHtml::openTag('li',array('class'=>'main-wrap'));
            $menu .= CHtml::link('Правила сайту','#',array('class'=>'main-link'));
            $menu .= CHtml::closeTag('li');
        }
        $menu .= CHtml::closeTag('ul');
        return $menu;
    }

}