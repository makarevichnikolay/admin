<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 06.03.13
 * Time: 10:13
 * To change this template use File | Settings | File Templates.
 */
?>

<div class="form-login">
<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'users-form',
        'type' => 'horizontal',
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
        <?php echo $form->textFieldRow($model, 'login'); ?>
        <?php echo $form->textFieldRow($model, 'nickname'); ?>
        <?php echo $form->passwordFieldRow($model, 'password'); ?>
        <?php echo $form->passwordFieldRow($model, 'password_repeat'); ?>
    </fieldset>

    <div class="form-actions">

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submitLink',
            'size' => false,
            'type' =>false,
            'label' => 'Реєструватись',
            'htmlOptions' => array('submit' => '','class'=>'main-btn' )
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>
</div>