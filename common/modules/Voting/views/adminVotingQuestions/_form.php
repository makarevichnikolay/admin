<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
$previewPrefix = Yii::app()->params['tempUrl'];
$imageSrc = Yii::app()->params['dataUrl'] . 'votingQuestions/' . $model->id . '/image/';
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'VotingQuestions-form',
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
<?php echo $form->dropDownListRow($model, 'voting_id', CHtml::listData(Voting::model()->findAll(),'id','title')); ?>
<?php echo $form->textFieldRow($model, 'title', array('class' => 'input-xxlarge')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'image', array('class' => 'control-label')); ?>
        <div class="controls">
            <div class="row-fluid">
                <?php
                if (!empty($model->image)) {
                    $display = true;
                } else {
                    $display = false;
                }
                $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                    array('id' => 'ImageUpload',
                        'config' => array('action' => $this->createUrl('/Voting/adminVotingQuestions/ImageUpload', array('field' => 'image')),
                            'allowedExtensions' => Yii::app()->params['VotingQuestions']['image']['ext'],
                            'sizeLimit' => Yii::app()->params['VotingQuestions']['image']['maxSize'],
                            'minSizeLimit' => 0,
                            'multiple' => false,
                            'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drag and drop</span></div>
                                          <div class="qq-upload-button btn btn-success">Загрузить</div><ul class="qq-upload-list"></ul></div>',
                            'fileTemplate' => '<li><span class="qq-upload-file"></span>
                                             <span class="qq-upload-spinner"></span> <span class="qq-upload-size"></span>
                                             <a class="qq-upload-cancel" href="#">' . Yii::t('eajaxupload', 'Отменить') . '</a>
                                             <span class="qq-upload-failed-text">' . Yii::t('eajaxupload', 'Ошыбка') . '</span>
                                              </li>',
                            'onComplete' => 'js:function(id, realFilename, responseJSON) {
                                                                         if(responseJSON.success){
                                                                            $("#main-image").attr("src","' . $previewPrefix . '"+responseJSON.filename);
                                                                            $("#main-image").show();
                                                                            $("#VotingQuestions_image").val(responseJSON.filename);
                                                                            $(".qq-upload-list").css("display","none");
                                                                            $(".main-image-delete").show();
                                                                           }
                                                                         }',

                        )
                    ));
                echo CHtml::ajaxLink('Удалить', Yii::app()->createUrl('/Voting/adminVotingQuestions/ImageDelete'),
                    array(
                        'type' => 'POST',
                        'data' => array('id' => $model->id, 'field' => 'image'),
                        'success' => "function(data)
								  {
								  		$('#main-image').hide();
								  		$('.main-image-delete').hide();
								  		$('#Pages_main_image').val('');
								  }",
                    ),
                    array(
                        'class' => 'main-image-delete btn btn-danger',
                        'style' => $display ? 'display:inline-block;' : 'display:none;',
                        "confirm" => 'Удалить картинку?',
                    ));
                echo $form->hiddenField($model, 'image');
                ?>
            </div>
            <?php
            if ($display) {
                echo Chtml::image(VotingQuestions::getImageSrc('image', 'thumb', $model->id, $model->image), 'image-upload', array(
                    'id' => 'main-image',
                    'class' => 'image-upload'
                ));
            } else {
                echo Chtml::image('#', 'image-upload', array('style' => 'display:none', 'id' => 'main-image', 'class' => 'image-upload'));
            }

            ?>
            <?php echo $form->error($model, 'image'); ?>
        </div>
    </div>
 <?php echo $form->textFieldRow($model, 'count', array('class' => 'input-xxlarge')); ?>
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