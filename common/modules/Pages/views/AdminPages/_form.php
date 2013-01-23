<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
?>

<div class="form">

<?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'horizontalForm',
    'type'=>'horizontal',
    'enableClientValidation'=>true,
)); ?>

    <fieldset>

        <legend>Legend</legend>

        <?php echo $form->textFieldRow($model, 'title', array('class'=>'input-xxlarge')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'url',array('class'=>'control-label')); ?>
            <div class="controls">
                <div class="input-append">
                 <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255,'class'=>'span5')); ?>

                 <?php $this->widget('bootstrap.widgets.TbButton', array('label'=>'Создать',
                                                                         'type'=>'info',
                                                                         'size'=>'normal',
                                                                         'htmlOptions'=>array('id'=>'button-create-url-chunk')
                                                                         )
                                     );
                 ?>
                </div>
                 <?php echo $form->error($model,'url'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'keywords', array('class'=>'input-xxlarge')); ?>
        <?php echo $form->textFieldRow($model, 'description', array('class'=>'input-xxlarge')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model,'categories',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php

                $this->widget('common.ext.EchMultiselect.EchMultiselect', array(
                    'model' => $model,
                    'dropDownAttribute' => 'categories',
                    'data' => $Categories,
                    'options'=>array(
                        'selectedList'=>4
                    ),
                    'dropDownHtmlOptions'=> array(
                        'class'=>'span6',
                    ),
                ));
                ?>
            </div>

        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'content',array('class'=>'control-label')); ?>
            <div class="controls">
                 <?php  $this->widget('common.ext.redactorjs.Redactor', array( 'model' => $model, 'attribute' => 'content' ,'lang'=>'ru')); ?>
                <?php echo $form->error($model,'content'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'image',array('class'=>'control-label')); ?>
            <div class="controls">
                <div class="row-fluid">
                <?php
                $previewPrefix = Yii::app()->params['tempUrl'];
                 if($model->image){
                     $display = true;
                 }else{
                     $display = false;
                 }
                $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                    array('id' => 'ImagesUpload',
                        'config' => array('action' => $this->createUrl('/Pages/adminPages/imageUpload'),
                            'allowedExtensions' => Yii::app()->params['Pages']['mainImage']['ext'],
                            'sizeLimit' => Yii::app()->params['Pages']['mainImage']['maxSize'],
                            'minSizeLimit' => 0,
                            'multiple' => false,
                            'template'=> '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drag and drop</span></div>
                                          <div class="qq-upload-button btn btn-success">Загрузить</div><ul class="qq-upload-list"></ul></div>',
                            'fileTemplate'=>'<li><span class="qq-upload-file"></span>
                                             <span class="qq-upload-spinner"></span> <span class="qq-upload-size"></span>
                                             <a class="qq-upload-cancel" href="#">'.Yii::t('eajaxupload', 'Отменить').'</a>
                                             <span class="qq-upload-failed-text">'.Yii::t('eajaxupload', 'Ошыбка').'</span>
                                              </li>',
                            'onComplete'=>'js:function(id, realFilename, responseJSON) {
                                                                         if(responseJSON.success){
                                                                            $("#image").attr("src","'.$previewPrefix.'"+responseJSON.filename);
                                                                            $("#image").show();
                                                                            $("#del").show();
                                                                            $("#image_name_temp").val(responseJSON.filename);
                                                                            $(".qq-upload-list").css("display","none");
                                                                            $(".delete-image").show();
                                                                           }
                                                                         }',

                        )
                    ));
                echo CHtml::ajaxLink('Удалить', Yii::app()->createUrl('/Pages/adminPages/DeleteImage'),
                    array(
                        'type' => 'POST',
                        'data'=>array('id'=>$model->id),
                        'success' => "function(data)
								  {
								  		$('#image').hide();
								  		$('.delete-image').hide();
								  		$('#image_name_temp').val('');
								  }",
                    ),
                    array(
                        'class' => 'delete-image btn btn-danger',
                        'style'=>$display?'display:inline-block;':'display:none;',
                        "confirm"=>'Удалить картинку?',
                    ));
                echo Chtml::hiddenField('image_name_temp');
                ?>
                </div>
                <?php
                if($display){
                    echo Chtml::image(Yii::app()->params['dataUrl'].'pages/'.$model->id.'/images/main/'.Yii::app()->params['Pages']['mainImage']['name'],'image-upload',array(
                              'id'=>'image',
                               'class'=>'image-upload'
                          ));
                }else{
                    echo Chtml::image('#','image-upload',array('style'=>'display:none','id'=>'image', 'class'=>'image-upload'));
                }

                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
        <?php

        ?>
             </div>
            </div>
        <?php echo $form->checkBoxRow($model, 'visible'); ?>
        <?php echo $form->checkBoxRow($model, 'allow_comments'); ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Submit')); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function()
    {
        $('.qq-upload-button').addClass('btn');
    })
</script>

<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('url', '
$("#button-create-url-chunk").on("click",function() {
$("#Pages_url").val(transliterate($("#Pages_title").val()));
return false;
});
', CClientScript::POS_READY);


?>