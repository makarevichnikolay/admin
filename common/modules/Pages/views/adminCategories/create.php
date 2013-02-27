<?php
/* @var $this AdminCategoriesController */
/* @var $model Categories */

$this->breadcrumbs=array(
	'Рубрики'=>array('index'),
	'Новая запись',
);

?>
<h2>Добавить рубрику</h2>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>