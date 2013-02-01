<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 01.02.13
 * Time: 16:24
 * To change this template use File | Settings | File Templates.
 */
class PhpAuthManager extends CPhpAuthManager{
    public function init(){
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('common.config.auth').'.php';
        }

        parent::init();
        if(!Yii::app()->user->isGuest){
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}