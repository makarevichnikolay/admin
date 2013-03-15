<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
$previewPrefix = Yii::app()->params['tempUrl'];
$imageSrc = Yii::app()->params['dataUrl'] . 'pages/' . $model->id . '/images/';
?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'page-form',
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
    <?php echo $form->labelEx($model, 'categories', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php

        $this->widget('common.ext.EchMultiSelect.EchMultiSelect', array(
            'model' => $model,
            'dropDownAttribute' => 'categories',
            'DropDownGroup' => AdminNewsController::getCategoriesSelect($model->categories, 'Pages_categories', 'Pages[categories][]', 'input-xxlarge width-fix'),
            //'data' => $Categories,
            'options' => array(
                'header' => false,
                'selectedList' => 4
            ),
            'dropDownHtmlOptions' => array(
                'class' => 'input-xxlarge width-fix',
                // 'id'=>'page-categories'
            ),
        ));
        ?>
        <?php echo $form->error($model, 'categories'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'date', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $this->widget('common.ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'date',
            'mode' => 'datetime',
            'options' => array(
                "dateFormat" => 'yy-mm-dd',
                "timeFormat" => 'hh:mm:ss',
                'showAnim' => 'fold',
            ),
            'htmlOptions' => array('class' => 'input-xxlarge', 'value' => ($model->isNewRecord)?date('Y-m-d H:i:s'):date('Y-m-d H:i:s',strtotime($model->date)), 'style' => 'position: relative; z-index: 3000;')
        ));
        ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'main_image', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="row-fluid">
            <?php
            if (!empty($model->main_image)) {
                $display = true;
            } else {
                $display = false;
            }
            $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                array('id' => 'ImageUpload',
                    'config' => array('action' => $this->createUrl('/Pages/adminNews/MainImageUpload', array('field' => 'main_image')),
                        'allowedExtensions' => Yii::app()->params['Pages']['main_image']['ext'],
                        'sizeLimit' => Yii::app()->params['Pages']['main_image']['maxSize'],
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
                                                                            $("#Pages_main_image").val(responseJSON.filename);
                                                                            $(".qq-upload-list").css("display","none");
                                                                            $(".main-image-delete").show();
                                                                           }
                                                                         }',

                    )
                ));
            echo CHtml::ajaxLink('Удалить', Yii::app()->createUrl('/Pages/adminNews/MainImageDelete'),
                array(
                    'type' => 'POST',
                    'data' => array('id' => $model->id, 'field' => 'main_image'),
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
            echo $form->hiddenField($model, 'main_image');
            ?>
        </div>
        <?php
        if ($display) {
            echo Chtml::image(Pages::getImageSrc('main_image', 'thumb', $model->id, $model->main_image), 'image-upload', array(
                'id' => 'main-image',
                'class' => 'image-upload'
            ));
        } else {
            echo Chtml::image('#', 'image-upload', array('style' => 'display:none', 'id' => 'main-image', 'class' => 'image-upload'));
        }

        ?>
        <?php echo $form->error($model, 'main_image'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'content', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php  $this->widget('common.ext.redactorjs.ERedactorWidget', array('model' => $model, 'attribute' => 'content',
        'options' => array(
            'lang' => 'ru',
            'minHeight' => 350,
            'imageUpload' => Yii::app()->createAbsoluteUrl('Pages/adminNews/imageUploadRedactor', array('attr' => 'content')),
            'imageGetJson' => Yii::app()->createUrl('Pages/adminNews/imageListRedactor', array('attr' => 'content')),

        )));?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
</div>
<div class="control-group">
    <div class="controls">
        <?php
        $button_class = $model->isNewRecord ? ' disabled' : ' admin-modal-show';
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Галерея',
            'type' => 'success',
            'size' => 'normall',
            'htmlOptions' => array(
                'class' => $button_class
            )
        )); ?>

    </div>
</div>
<?php echo $form->textFieldRow($model, 'video', array('class' => 'input-xxlarge')); ?>
<?php echo $form->checkBoxRow($model, 'video_new'); ?>
<?php echo $form->checkBoxRow($model, 'photo_new'); ?>
<?php echo $form->checkBoxRow($model, 'visible', array('checked' => ($model->isNewRecord || $model->visible)?'checked':'')); ?>
<?php echo $form->checkBoxRow($model, 'visible_on_main'); ?>
<?php echo $form->checkBoxRow($model, 'hidden_in_main_list'); ?>
<?php echo $form->checkBoxRow($model, 'allow_comments', array('checked' => ($model->isNewRecord || $model->allow_comments)?'checked':'')); ?>
<?php echo $form->textFieldRow($model, 'title_meta', array('class' => 'input-xxlarge')); ?>
<?php echo $form->textFieldRow($model, 'keywords_meta', array('class' => 'input-xxlarge')); ?>
<?php echo $form->textFieldRow($model, 'description_meta', array('class' => 'input-xxlarge')); ?>
<?php echo $form->textFieldRow($model, 'author_name', array('class' => 'input-xxlarge')); ?>
<div class="control-group">
    <?php echo $form->labelEx($model, 'author_image', array('class' => 'control-label')); ?>
    <div class="controls">
        <div class="row-fluid">
            <?php
            if (!empty($model->author_image)) {
                $display_author = true;
            } else {
                $display_author = false;
            }
            $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                array('id' => 'ImageUploadAuthor',
                    'config' => array('action' => $this->createUrl('/Pages/adminNews/MainImageUpload', array('field' => 'author_image')),
                        'allowedExtensions' => Yii::app()->params['Pages']['author_image']['ext'],
                        'sizeLimit' => Yii::app()->params['Pages']['author_image']['maxSize'],
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
                                                                            $("#author-image").attr("src","' . $previewPrefix . '"+responseJSON.filename);
                                                                            $("#author-image").show();
                                                                            $("#Pages_author_image").val(responseJSON.filename);
                                                                            $(".qq-upload-list").css("display","none");
                                                                            $(".author-image-delete").show();
                                                                           }
                                                                         }',

                    )
                ));
            echo CHtml::ajaxLink('Удалить', Yii::app()->createUrl('/Pages/adminNews/MainImageDelete'),
                array(
                    'type' => 'POST',
                    'data' => array('id' => $model->id, 'field' => 'author_image'),
                    'success' => "function(data)
								  {
								  		$('#author-image').hide();
								  		$('.author-image-delete').hide();
								  		$('#Pages_author_image').val('');
								  }",
                ),
                array(
                    'class' => 'main-image-delete btn btn-danger',
                    'style' => $display_author ? 'display:inline-block;' : 'display:none;',
                    "confirm" => 'Удалить картинку?',
                ));
            echo $form->hiddenField($model, 'author_image');
            ?>
        </div>
        <?php
        if ($display_author) {
            echo Chtml::image(Pages::getImageSrc('author_image', 'thumb', $model->id, $model->author_image), 'image-upload', array(
                'id' => 'author-image',
                'class' => 'image-upload'
            ));
        } else {
            echo Chtml::image('#', 'image-upload', array('style' => 'display:none', 'id' => 'author-image', 'class' => 'image-upload'));
        }

        ?>
        <?php echo $form->error($model, 'author_image'); ?>
    </div>
</div>
<div class="control-group">
    <?php echo $form->labelEx($model, 'author_description', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php  $this->widget('common.ext.redactorjs.ERedactorWidget', array('model' => $model, 'attribute' => 'author_description',
        'options' => array(
            'lang' => 'ru',
            'minHeight' => 150,
            'imageUpload' => Yii::app()->createAbsoluteUrl('Pages/adminNews/imageUploadRedactor', array('attr' => 'author_description')),
            'imageGetJson' => Yii::app()->createUrl('Pages/adminNews/imageListRedactor', array('attr' => 'author_description')),
        ))); ?>
        <?php echo $form->error($model, 'author_description'); ?>
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



<?php



?>