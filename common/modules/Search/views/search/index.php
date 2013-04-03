<?php
/* @var $this DefaultController */
$this->title = 'Пошук';
$this->pageTitle = 'Пошук';

?>
<div class="new-content">
<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$itemsProvider,
    'itemView'=>'_post',
    'template'=>'{items}{pager}',
));
?>
</div>