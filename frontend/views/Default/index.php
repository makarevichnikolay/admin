<?php

?>
<div class="row-fluid main-news">
    <div class="span12 clearfix ">
    <?php $this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$main_news,
    'itemView'=>'_main_news',
    'template'=>'{items}'
    )); ?>
    </div>
</div>

    <div class="row-fluid banner">
    </div>
 <div class="row-fluid main-tabs">
     <?php $this->widget('bootstrap.widgets.TbTabs', array(
     'type'=>'tabs',
     'tabs'=>array(
         array('label'=>'Свіжі новини', 'content'=>'еуіе', 'active'=>true),
         array('label'=>'Найбільше читають', 'content'=>' іуеіу'),
         array('label'=>'Найбільше коментують', 'content'=>'уіее '),
     ),
 )); ?>
 </div>

