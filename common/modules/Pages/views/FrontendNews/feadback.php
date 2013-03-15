<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 07.03.13
 * Time: 15:18
 * To change this template use File | Settings | File Templates.
 */
$this->title="Ти репортер";
$this->pageTitle="Ти репортер";
?>
<div class="form-login">
    <?php

if(!$emailSend){
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'feadback',
        'type' => 'horizontal',
        'enableClientValidation' => false,
        'enableAjaxValidation' => true,
        'htmlOptions'=>array(
            'enctype'=>'multipart/form-data',
        ),
        'clientOptions' => array(
            'validateOnSubmit' => true,

            'afterValidate' => 'js:function(form, data, hasError){
                             if(hasError){
                              $(".control-group.error:first").scrollToMe();
                              return false;
                             }else{
                               return true;
                             }
                            }'
        ),
    ));

?>
<fieldset>
    <?php echo $text; ?>
    <?php echo $form->textFieldRow($model, 'name', array()); ?>
    <?php echo $form->textFieldRow($model, 'lastName', array()); ?>
    <?php echo $form->textAreaRow($model, 'about', array()); ?>
    <?php echo $form->textFieldRow($model, 'email', array()); ?>
    <?php echo $form->textFieldRow($model, 'phone', array()); ?>
    <?php echo $form->fileFieldRow($model, 'file', array('id'=>'file')); ?>
    <?php echo $form->fileFieldRow($model, 'image', array()); ?>
</fieldset>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submitLink',
        'label' => 'Відправити',
        'htmlOptions' => array('submit' => '','class'=>'main-btn')
    ));
    ?>
</div>

<?php $this->endWidget(); }else{?>
    <fieldset>
    <?php
    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'60',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'60'),
        )));?>
    <?php } ?>
    </fieldset>
</div>
