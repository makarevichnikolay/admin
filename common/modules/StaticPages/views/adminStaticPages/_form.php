<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'StaticPages',
    'type' => 'horizontal',
    'enableClientValidation' => false,
    'enableAjaxValidation' => true,
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
)); ?>

<fieldset>

<legend></legend>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'input-xxlarge')); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'url', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="input-append">
            <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 255, 'class' => 'input-xxlarge')); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('label' => 'Создать',
                'type' => 'info',
                'icon' => 'plus white',
                'size' => 'normal',
                'htmlOptions' => array('id' => 'button-create-url-chunk')
            )
        );
            ?>
        </div>
        <?php echo $form->error($model, 'url'); ?>
    </div>
</div>

<div class="control-group">
    <?php echo $form->labelEx($model, 'content', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php  $this->widget('common.ext.redactorjs.ERedactorWidget', array('model' => $model, 'attribute' => 'content',
        'options' => array(
            'lang' => 'ru',
            'minHeight' => 350,
            'imageUpload' => Yii::app()->createAbsoluteUrl('staticPages/adminStaticPages/imageUploadRedactor', array('attr' => 'content')),
            'imageGetJson' => Yii::app()->createAbsoluteUrl('staticPages/adminStaticPages/imageListRedactor', array('attr' => 'content')),

        )));?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
</div>
<?php echo $form->checkBoxRow($model, 'visible', array('checked' => ($model->isNewRecord || $model->visible)?'checked':'')); ?>
<?php echo $form->textFieldRow($model, 'title_meta', array('class' => 'input-xxlarge')); ?>
<?php echo $form->textFieldRow($model, 'keywords_meta', array('class' => 'input-xxlarge')); ?>
<?php echo $form->textFieldRow($model, 'description_meta', array('class' => 'input-xxlarge')); ?>
</fieldset>

<div class="form-actions">

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submitLink',
        'size' => 'large',
        'icon' => 'ok white',
        'type' => 'primary',
        'label' => 'Сохранить',
        'htmlOptions' => array('submit' => '', 'params' => array('redirect' => 'index'))
    ));
    ?>
    &nbsp
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submitLink',
        'size' => 'large',
        'icon' => 'ok white',
        'type' => 'primary',
        'label' => 'Сохранить и продолжыть',
        'htmlOptions' => array('submit' => '', 'params' => array('redirect' => 'update'))
    ));
    ?>
</div>

<?php $this->endWidget(); ?>


<script type="text/javascript">
    $("#button-create-url-chunk").on("click",function() {
        $("#StaticPages_url").val(transliterate($("#StaticPages_title").val()));
        return false;
    });
</script>