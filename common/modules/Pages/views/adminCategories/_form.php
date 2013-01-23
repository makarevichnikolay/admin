<?php
/* @var $this AdminCategoriesController */
/* @var $model Categories */
/* @var $form CActiveForm */
?>


    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
)); ?>

    <fieldset>

        <legend>Legend</legend>
        <?php echo $form->textFieldRow($model, 'title', array('class'=>'input-xxlarge')); ?>
     </fieldset>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->