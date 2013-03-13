<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 01.02.13
 * Time: 16:11
 * To change this template use File | Settings | File Templates.
 */
class WebUser extends CWebUser {
    private $_model = null;

    function getRole() {
        if($user = $this->getModel()){
            return $user->role->name;
        }
    }

    function getBanned() {
        if($user = $this->getModel()){
            return $user->banned;
        }
    }

    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = Users::model()->findByPk($this->id);
        }
        return $this->_model;
    }
}