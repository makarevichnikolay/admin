<?php
/* @var $this AdminUsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Баннеры'=>array('index'),
    $model->title=>Yii::app()->controller->createUrl("AdminBanners/update", array("id" => $model->id)),
    'Редактирование'
);

?>
<h2>Редактировать баннера <?php echo $model->title ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>