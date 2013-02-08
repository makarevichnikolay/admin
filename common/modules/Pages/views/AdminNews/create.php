<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Pages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Page', 'url'=>array('index')),
	array('label'=>'Manage Page', 'url'=>array('admin')),
);
?>

<h1>Create Page</h1>
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
