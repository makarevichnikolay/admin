<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 12.03.13
 * Time: 15:24
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
if(isset($data->pageInfo)){
    $count_comments =$data->pageInfo->count_comments;
    $count_visited =$data->pageInfo->count_visited;
}else{
    $count_comments = $count_visited = 0;
}
$provider = Pages::getByCategory($data->id);
if(count($provider->getData())>0):
?>
<article class="row-fluid main-dose">
    <div class="name"><?php echo CHtml::link($data->title,Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$data->id)))?></div>
    <?php
    $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider'=>$provider,
        'itemView'=>'_dose',
        'template'=>'{items}',
        'pager' => false
    ));
    ?>
    <div class="all"><?php echo CHtml::link('Всі записи рубрики "'.$data->title.'"',Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$data->id)))?></div>
</article>
<?php  endif; ?>