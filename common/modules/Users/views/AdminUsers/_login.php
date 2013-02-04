<div class="row-fluid">
<div class="well span4 offset4">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'users-form',
    'type' => 'vertical',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'afterValidate'=>'js:function(form, data, hasError){
                             if(hasError){
                              $(".control-group.error:first").scrollToMe();
                              return false;
                             }else{
                               return true;
                             }
                            }'
    ),
)); ?>

    <fieldset>

        <legend>Авторизация</legend>
        <?php echo $form->error($model,'password_repeat') ?>
        <?php echo $form->textFieldRow($model, 'login', array('class' => '')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array('class' => '')); ?>
    </fieldset>

<div class="form-actions">

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submitLink',
        'size' => 'normal',
        'icon' => 'ok white',
        'type' => 'success',
        'label' => 'Вход',
        'htmlOptions' => array('submit' => '' , 'params'=>array('redirect'=>'index'))
    ));
    ?>
</div>

<?php $this->endWidget(); ?>
</div>
</div>