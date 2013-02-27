<?php
/* @var $this AdminUsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Пользователи'=>array('index'),
    'Новая запись',
);

?>

<h2>Добавить пользователя</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>