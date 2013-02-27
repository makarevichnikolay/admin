<div class="row-fluid">
<div class="well span4 offset4">
<?php

    if(Yii::app()->user->isGuest){
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'users-form',
            'type' => 'vertical',
            'action'=>$this->createUrl('/Users/Users/Login'),
            'enableClientValidation' => true,
            'enableAjaxValidation'=>true,
            'clientOptions'=>array(
                'validateOnSubmit'=>true,
                'afterValidate'=>'js:function(form, data, hasError){
                             if(hasError){
                              $(".control-group.error:first").scrollToMe();
                              return false;
                             }else{
                               window.location = "'.$this->createUrl('/').'";
                               return false;
                             }
                            }'
            ),
        )); ?>

        <fieldset>

            <legend>Авторизация</legend>
            <?php //echo $form->errorSummary($model); ?>
            <?php echo $form->hiddenField($model,'password_repeat') ?>
            <?php echo $form->error($model,'password_repeat') ?>
            <?php echo $form->textFieldRow($model, 'login', array('class' => '')); ?>
            <?php echo $form->textFieldRow($model, 'password', array('class' => '')); ?>
        </fieldset>

<div class="form-actions">

    <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submitLink',
            'size' => 'normal',
            'icon' => 'ok white',
            'type' => 'success',
            'label' => 'Вход',
        ));
    ?>
    </div>

    <?php $this->endWidget(); ?>
    <?php
    }else{
        echo Yii::app()->user->name;
        echo CHtml::link('Выход',$this->createUrl('Users/Users/Logout'));
    }
    ?>

</div>
</div>