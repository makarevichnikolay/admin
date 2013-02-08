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

        <legend>Legend</legend>
        <?php echo $form->dropDownListRow($model, 'parent_id',CHtml::listData(Categories::model()->findAll('parent_id=:parent_id',array(':parent_id'=>0)),'id','title') ,array('class'=>'input-xxlarge','disabled'=>$disabled)); ?>
        <?php echo $form->textFieldRow($model, 'title', array('class'=>'input-xxlarge')); ?>
     </fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->