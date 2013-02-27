<?php
/* @var $this AdminUsersController */
/* @var $model Users */

$this->breadcrumbs=array(
    'Баннеры'=>array('index'),
    'Новая запись',
);

?>

<h2>Добавить баннер</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>