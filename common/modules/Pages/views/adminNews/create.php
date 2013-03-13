<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
    'Новости'=>array('index'),
    'Новая запись',
);
?>

<h2>Добавить новость</h2>
<div class="form">
<?php echo $this->renderPartial('_form', $params); ?>
</div><!-- form -->
<?php
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/Pages/pages-form.js', CClientScript::POS_END);
$cs->registerScript('init', '
$(document).ready(function () {
Pages.init();
})
', CClientScript::POS_READY);



?>
