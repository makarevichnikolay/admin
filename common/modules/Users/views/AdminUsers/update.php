<?php
/* @var $this AdminUsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Пользователи'=>array('index'),
    $model->nickname=>Yii::app()->controller->createUrl("AdminUsers/update", array("id" => $model->id)),
    'Редактирование'
);

?>
<h2>Редактировать пользователя <?php echo $model->nickname ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>