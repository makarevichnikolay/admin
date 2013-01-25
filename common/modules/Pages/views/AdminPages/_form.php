<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form CActiveForm */
$previewPrefix = Yii::app()->params['tempUrl'];
$imageSrc = Yii::app()->params['dataUrl'].'pages/'.$model->id.'/images/';
?>
<div class="admin-modal pages-modal hide fade out">
    <button type="button" class="close admin-close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <div class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="well">
                <h1>Фото</h1>
                    <div class='pull-right' id="count"></div>
                <?php
                $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                    array('id' => 'ImagesUpload',
                        'config' => array(
                            'action' => $this->createUrl('/Pages/adminPages/imageUpload',array('id'=>$model->id)),
                            'allowedExtensions' => Yii::app()->params['Pages']['mainImage']['ext'],
                            'sizeLimit' => Yii::app()->params['Pages']['mainImage']['maxSize'],
                            'minSizeLimit' => 0,
                            'multiple' => true,
                            'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drag and drop</span></div>
                                          <div class="qq-upload-button btn btn-success">Загрузить</div><ul id="images-upload-list" class="qq-upload-list"></ul></div>',
                            'fileTemplate' => '<li><span class="qq-upload-file"></span>
                                             <span class="qq-upload-spinner"></span> <span class="qq-upload-size"></span>
                                             <a class="qq-upload-cancel" href="#">' . Yii::t('eajaxupload', 'Отменить') . '</a>
                                             <span class="qq-upload-failed-text">' . Yii::t('eajaxupload', 'Ошыбка') . '</span>
                                              </li>',
                            'onComplete' => 'js:function(id, realFilename, responseJSON) {
                                                                         if(responseJSON.success){
                                                                            validMaxCount(responseJSON.curCount,responseJSON.maxCount)
                                                                            renderImage(responseJSON.data);
                                                                           }
                                                                         }',

                        )
                    ));
                   ?>
                </div>
                <div class="list-view">
                    <div class="thumbnails" id="result">
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'horizontalForm',
        'type' => 'horizontal',
        'enableClientValidation' => true,
    )); ?>

    <fieldset>

        <legend>Legend</legend>

        <?php echo $form->textFieldRow($model, 'title', array('class' => 'input-xxlarge')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'url', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="input-append">
                    <?php echo $form->textField($model, 'url', array('size' => 60, 'maxlength' => 255, 'class' => 'span5')); ?>

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
        <?php echo $form->textFieldRow($model, 'keywords', array('class' => 'input-xxlarge')); ?>
        <?php echo $form->textFieldRow($model, 'description', array('class' => 'input-xxlarge')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'categories', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php

                $this->widget('common.ext.EchMultiselect.EchMultiselect', array(
                    'model' => $model,
                    'dropDownAttribute' => 'categories',
                    'data' => $Categories,
                    'options' => array(
                        'selectedList' => 4
                    ),
                    'dropDownHtmlOptions' => array(
                        'class' => 'span6',
                    ),
                ));
                ?>
            </div>

        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'content', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php  $this->widget('common.ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'content', 'lang' => 'ru')); ?>
                <?php echo $form->error($model, 'content'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'image', array('class' => 'control-label')); ?>
            <div class="controls">
                <div class="row-fluid">
                    <?php
                    if ($model->image) {
                        $display = true;
                    } else {
                        $display = false;
                    }
                    $this->widget('common.ext.EAjaxUpload.EAjaxUpload',
                        array('id' => 'ImageUpload',
                            'config' => array('action' => $this->createUrl('/Pages/adminPages/MainImageUpload'),
                                'allowedExtensions' => Yii::app()->params['Pages']['mainImage']['ext'],
                                'sizeLimit' => Yii::app()->params['Pages']['mainImage']['maxSize'],
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
                                                                            $("#image").attr("src","' . $previewPrefix . '"+responseJSON.filename);
                                                                            $("#image").show();
                                                                            $("#del").show();
                                                                            $("#image_name_temp").val(responseJSON.filename);
                                                                            $(".qq-upload-list").css("display","none");
                                                                            $(".delete-image").show();
                                                                           }
                                                                         }',

                            )
                        ));
                    echo CHtml::ajaxLink('Удалить', Yii::app()->createUrl('/Pages/adminPages/MainImageDelete'),
                        array(
                            'type' => 'POST',
                            'data' => array('id' => $model->id),
                            'success' => "function(data)
								  {
								  		$('#image').hide();
								  		$('.main-image-delete').hide();
								  		$('#image_name_temp').val('');
								  }",
                        ),
                        array(
                            'class' => 'main-image-delete btn btn-danger',
                            'style' => $display ? 'display:inline-block;' : 'display:none;',
                            "confirm" => 'Удалить картинку?',
                        ));
                    echo Chtml::hiddenField('image_name_temp');
                    ?>
                </div>
                <?php
                if ($display) {
                    echo Chtml::image(Yii::app()->params['dataUrl'] . 'pages/' . $model->id . '/images/main/' . Yii::app()->params['Pages']['mainImage']['name'], 'image-upload', array(
                        'id' => 'image',
                        'class' => 'image-upload'
                    ));
                } else {
                    echo Chtml::image('#', 'image-upload', array('style' => 'display:none', 'id' => 'image', 'class' => 'image-upload'));
                }

                ?>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <?php
                $button_class = $model->isNewRecord ? ' disabled' : ' admin-modal-show';
                $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'Загрузить Фотографии',
                'type'=>'success',
                'size'=>'normall',
                'htmlOptions'=>array(
                    'class'=>$button_class
                )
            )); ?>

            </div>
        </div>
        <?php echo $form->checkBoxRow($model, 'visible'); ?>
        <?php echo $form->checkBoxRow($model, 'allow_comments'); ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'size' => 'large', 'icon' => 'ok white', 'type' => 'primary', 'label' => 'Сохранить')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    var transforms = {
            item:[
                {tag:'li', class:'images-box', children:[
                    {tag:'div', class:'thumbnail', children:[
                        {tag:'img', src:'${src}'},
                        {tag:'form', class:'pages-form', 'method':'post', children:[
                            {tag:'fieldset', children:[
                                {tag:'input', 'type':'text', 'name':'title', 'value':'${title}'},
                                {tag:'div', html:'<button class="btn pull-left save-image" data-id="${id}" type="button">' +
                                    '<i class="icon-ok"></i></button>' +
                                    '<button class="btn pull-right delete-image" data-id="${id}"  type="button">' +
                                    '<i class="icon-remove"></i></button>'
                                }
                            ]}
                        ]
                        }
                    ]
                    }
                ]
                }
            ]
        }
        ;


    function getAllImages(){
        $.ajax({
           type: "POST",
            url: '<?php echo $this->createUrl('/Pages/AdminPages/GetImagesJSON',array('page_id'=>$model->id)) ?>'
        }).done(function( data ) {
                var result = $.parseJSON(data);
                validMaxCount(result['curCount'], result['maxCount']);
                for(var value in result){
                   renderImage(result[value]);
                }
        });
    }
    function renderImage(data){
         $('#result').json2html(data,transforms.item);
    }
    function validMaxCount(cur,max){
        if(cur < max){
            $('#count').html('<i>загружено</i> <span class="badge badge-success"><span id="curCount">'+cur+'</span> c ' + max+'</span>');
        }else{
            setTimeout(function(){
                $('#ImagesUpload > .qq-uploader > .qq-upload-button').addClass('disabled');
                $('#ImagesUpload > .qq-uploader > .qq-upload-button >input').on('click',function(){return false;})
                $("#images-upload-list").css('display','none');
            },1000)
            $('#count').html('<i>загружено</i> <span class="badge badge-important"><span id="curCount">'+cur+'</span> c ' + max+'</span>');
        }
    }

    function deleteImage(data){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->createUrl('/Pages/AdminPages/imageDelete') ?>',
            data:data
        }).done(function( data ) {
                $("#ImagesUpload > .qq-uploader > .qq-upload-button >input").unbind('click');
                $('#ImagesUpload > .qq-uploader > .qq-upload-button').removeClass('disabled');
                var count =$('#curCount').html();
                $('#curCount').html(--count).parent().removeClass('badge-important').addClass('badge-success');
            });
    }


    function updateImage(data){
        $.ajax({
            type: "POST",
            url: '<?php echo $this->createUrl('/Pages/AdminPages/imageUpdate') ?>',
            data:data
        });
    }

    $(document).ready(function () {
        getAllImages();
        $(document).on('click', '.save-image',function(e){
            var title =$(this).parent().siblings('input').val();
            var id = $(this).data('id');
            var data = {id:id,title:title};
            updateImage(data);
            $(this).addClass('save-image-ok').delay(1000).queue(function() {
                $(this).removeClass('save-image-ok');
                $(this).dequeue();
            });
        } );

        $(document).on('click','.delete-image',function(e){
            var id = $(this).data('id');
            var data = {id:id};
            deleteImage(data);
            $(this).closest('li.images-box').remove();
        });

        $('.admin-modal-show').on('click', function () {
            $('.admin-modal').show().toggleClass('in out');
            $('.admin-modal').scrollToMe();
        })
        $('.close').on('click', function () {
            $('.admin-modal').toggleClass('in out').hide();
        });
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