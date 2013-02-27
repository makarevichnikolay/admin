<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Новости'=>array('index'),
    $params['model']->title=>Yii::app()->controller->createUrl("AdminNews/update", array("id" =>$params['model']->id)),
    'Редактирование'
);
?>

<h2>Редактировать новость: <?php echo $params['model']->title ?></h2>

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
                                'action' => $this->createUrl('/Pages/adminNews/imageUpload',array('id'=>$params['model']->id)),
                                'allowedExtensions' => Yii::app()->params['Pages']['images']['ext'],
                                'sizeLimit' => Yii::app()->params['Pages']['images']['maxSize'],
                                'minSizeLimit' => 0,
                                'multiple' => true,
                                'template' => '<div class="qq-uploader"><div class="qq-upload-drop-area"><span>Drag and drop</span></div>
                                          <div class="qq-upload-button btn btn-success">Загрузить</div><ul id="images-upload-list" class="qq-upload-list"></ul></div>',
                                'fileTemplate' => '<li style="display:none;"><span class="qq-upload-file"></span>
                                             <span class="qq-upload-spinner"></span> <span class="qq-upload-size"></span>
                                             <a class="qq-upload-cancel" href="#">' . Yii::t('eajaxupload', 'Отменить') . '</a>
                                             <span class="qq-upload-failed-text">' . Yii::t('eajaxupload', 'Ошыбка') . '</span>
                                              </li>',
                                'onComplete' => 'js:function(id, realFilename, responseJSON) {
                                                                         if(responseJSON.success){
                                                                            PagesUpdate.validMaxCount(responseJSON.curCount,responseJSON.maxCount)
                                                                            PagesUpdate.renderImage(responseJSON.data);
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
<?php echo $this->renderPartial('_form', $params); ?>
</div><!-- form -->
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScript('var', '
var GetImagesJSON ="' . Yii::app()->createUrl("/Pages/AdminNews/GetImagesJSON",array("page_id"=>$params['model']->id)) .'";
var updateImageUrl = "'.$this->createUrl("/Pages/AdminNews/imageUpdate").'";
var deleteImageUrl = "'.$this->createUrl("/Pages/AdminNews/imageDelete").'";

', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/Pages/pages-form.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/Pages/pages-form-update.js', CClientScript::POS_END);
$cs->registerScript('init', '
$(document).ready(function () {
Pages.init();
PagesUpdate.init();
})
', CClientScript::POS_READY);
?>