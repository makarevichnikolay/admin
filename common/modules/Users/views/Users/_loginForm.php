<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 01.03.13
 * Time: 11:38
 * To change this template use File | Settings | File Templates.
 */
?>
<form action="<?php echo Yii::app()->createUrl('Users/Users/Login');?>" id="userLogin">
<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <div class="span12">
               <div id="userLogin-error"></div>
            </div>
        </div>
        <div class="row-fluid">
              <input class="span12" name="Users[login]" type="text">
        </div>
        <div class="row-fluid">
            <input class="span7" name="Users[password]" type="password">
             <a id="login" href="#" class="span5 pull-right btn btn-success">Вхід</a>
        </div>
    </div>
</div>
</form>
