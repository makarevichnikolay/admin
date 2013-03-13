<?php
/* @var $this PageController */
/* @var $model Page */

$this->breadcrumbs=array(
	'Голосования'=>array('index'),
    $params['model']->title=>Yii::app()->controller->createUrl("AdminVoting/update", array("id" =>$params['model']->id)),
    'Редактирование'
);
?>

<h2>Редактировать голосование: <?php echo $params['model']->title ?></h2>

<div class="form">
<?php echo $this->renderPartial('_form', $params); ?>
</div><!-- form -->
<?php
?>