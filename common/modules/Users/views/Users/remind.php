
<div class="form-login">


<?php
    if(!$emailSend){
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
    </fieldset>

    <div class="form-actions">

        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submitLink',
            'size' => false,
            'type' =>false,
            'label' => 'Відправити',
            'htmlOptions' => array('submit' => '','class'=>'main-btn' )
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