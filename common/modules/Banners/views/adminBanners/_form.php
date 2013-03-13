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
        <?php echo $form->textFieldRow($model, 'title'); ?>
        <?php echo $form->textAreaRow($model, 'content'); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'content2', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php  $this->widget('common.ext.redactorjs.ERedactorWidget', array('model' => $model, 'attribute' => 'content2',
                'options' => array(
                    'lang' => 'ru',
                    'minHeight' => 350,
                    'imageUpload' => Yii::app()->createAbsoluteUrl('Banners/adminBanners/imageUploadRedacotr', array('attr' => 'content2')),
                    'imageGetJson' => Yii::app()->createUrl('Pages/adminBanners/imageListRedactor', array('attr' => 'content2')),

                )));?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>
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