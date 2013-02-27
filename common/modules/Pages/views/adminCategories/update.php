<?php
/* @var $this AdminCategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Рубрики'=>array('index'),
	$model->title=>Yii::app()->controller->createUrl("AdminCategories/update", array("id" => $model->id)),
    'Редактирование'
);

?>
<h2>Редактировать рубрику <?php echo $model->title ?></h2>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>