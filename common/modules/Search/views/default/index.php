<?php
/* @var $this DefaultController */

$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$itemsProvider,
    'itemView'=>'_post',
));