<?php
/* @var $this AdminCategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>
<?php
$disabled = (!$model->isNewRecord && $model->parent_id == 0)?'disabled':'';
?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
)); ?>

    <fieldset>

        <legend></legend>
        <?php echo $form->textFieldRow($model, 'title', array('class'=>'input-xxlarge')); ?>
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
        <?php echo $form->dropDownListRow($model, 'parent_id',CHtml::listData(Categories::model()->findAll('parent_id=:parent_id',array(':parent_id'=>0)),'id','title') ,array('class'=>'input-xxlarge','disabled'=>$disabled)); ?>
     </fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary','icon' => 'ok white','label' => 'Сохранить',)); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $("#button-create-url-chunk").on("click",function() {
        $("#Categories_url").val(transliterate($("#Categories_title").val()));
        return false;
    });
</script>