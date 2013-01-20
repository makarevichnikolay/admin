<?php
$cs = Yii::app()->getClientScript();
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
?>

<div class="container-fluid">
    <div class="row">
        <div class="span7">
                <?php
                $errorClass = CHtml::$errorCss;
                $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                    'id' => 'Menu-Form',
                    'type' => 'horizontal',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'stateful' => true,
                    'clientOptions' => array(
                        'validateOnChange' => true,
                        'validateOnType' => true,
                        'afterValidateAttribute' => "js:
                function(form,attribute,data,hasError) {
                form.find('#'+attribute.inputID).removeClass('$errorClass');
                form.find('label[for='+attribute.inputID+']').removeClass('$errorClass');
        }
        "
                        //Fixes #1942 CActiveForm client validation
                    ),
                )); ?>

                <fieldset>
                    <legend>Legend</legend>

                    <?php echo $form->textFieldRow($model, 'title', array()); ?>
                    <?php echo $form->textAreaRow($model, 'url', array()); ?>
                </fieldset>




                <?php $this->endWidget(); ?>
            <div class="form-actions">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType' => 'ajaxButton',
                    'label' => 'Сохранить',
                    'type' => 'primary',
                    'size' => 'normal',
                    'url' => $this->createUrl('/Menu/AdminMenu/Create'),
                    'htmlOptions' => array(
                        'id' => 'menu-create',
                        "live" => false
                    ),
                    'ajaxOptions' => array(
                        'type' => 'POST',
                        'dataType' => 'json',
                        'data' => 'js:$("#Menu-Form").serialize()', //this one
                        'success' => 'js:function(data){
                                          if(data.result==="save"){
                                               renderMenu();
                                               $(".admin-modal").hide();
                                           }else{
                                               $("#result").html(data.result);
                                           }
                                      }',
                    )
                ));

                ?>
            </div>
        </div>
    </div>

</div>
