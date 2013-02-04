<?php

class UserIdentity extends CUserIdentity {
    protected $_id;


    public function authenticate(){

        $user = Users::model()->find('LOWER(login)=?', array(strtolower($this->username)));
        if(($user===null) || ($this->password!==$user->password)) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->nickname;
            $user->last_visited = new CDbExpression('NOW()');
            $user->ip = Users::GetRealIp();
            $user->update(array('last_visited','ip'));
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId(){
        return $this->_id;
    }
}