<?php
/* @var $this AdminUsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">
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
        <legend></legend>
        <?php echo $form->textFieldRow($model, 'login'); ?>
        <?php echo $form->textFieldRow($model, 'nickname'); ?>
        <?php echo $form->passwordFieldRow($model, 'password'); ?>
        <?php echo $form->passwordFieldRow($model, 'password_repeat'); ?>
        <?php echo $form->dropDownListRow($model, 'role_id', CHtml::listData( UsersRole::model()->findAll(),'id','description')); ?>
        <?php echo $form->textFieldRow($model, 'first_name'); ?>
        <?php echo $form->textFieldRow($model, 'last_name'); ?>
        <?php echo $form->textFieldRow($model, 'phone'); ?>
    </fieldset>

    <div class="form-actions">

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submitLink',
            'size' => 'large',
            'icon' => 'ok white',
            'type' => 'primary',
            'label' => 'Сохранить',
            'htmlOptions' => array('submit' => '' , 'params'=>array('redirect'=>'index'))
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- form -->