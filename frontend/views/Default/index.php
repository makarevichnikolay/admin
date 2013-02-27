<?php
$this->breadcrumbs = array();
?>
<div class="row-fluid main-news">
    <div class="span12 clearfix ">
    <?php $this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>Pages::getMainNews(),
    'itemView'=>'_main_news',
    'template'=>'{items}'
    )); ?>
    </div>
</div>

<div class="row-fluid">
    <?php
    Yii::app()->getModule('Banners');
    echo Banners::getBanner(2);
    ?>
</div>
 <div class="row-fluid main-tabs">
     <?php $this->widget('bootstrap.widgets.TbTabs', array(
     'type'=>'tabs',
     'tabs'=>array(
         array('label'=>'Свіжі новини',
             'content'=>$this->widget('bootstrap.widgets.TbListView', array(
                 'dataProvider'=>Pages::getFreshNews(),
                 'itemView'=>'common.modules.Pages.views.frontendNews._new',
                 'template'=>'{items}'
             ),true),
             'active'=>true),
         array('label'=>'Найбільше читають', 'content'=>' іуеіу'),
         array('label'=>'Найбільше коментують', 'content'=>'уіее '),
     ),
 )); ?>
 </div>

<script type="text/javascript">
    var menuActive = 'main';
</script>