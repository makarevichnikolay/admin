<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'voting-form',
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
    <?php echo $form->textFieldRow($model, 'question_vote', array('class' => 'input-xxlarge')); ?>
<?php echo $form->checkBoxRow($model, 'visible', array('checked' => ($model->isNewRecord || $model->visible)?'checked':'')); ?>
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