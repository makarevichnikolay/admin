<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 22.03.13
 * Time: 10:52
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
$provider = Pages::getByCategory($data->id,10);
if(count($provider->getData())>0):
    ?>
<article class="row-fluid main-work">
    <div class="name"><?php echo CHtml::link($data->title,Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$data->id)))?></div>
    <?php
    $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider'=>$provider,
        'itemView'=>'_work',
        'template'=>'{items}',
        'pager' => false
    ));
    ?>
    <div class="all"><?php echo CHtml::link('Всі записи рубрики "'.$data->title.'"',Yii::app()->createUrl('Pages/FrontendPages/index',array('id'=>$data->id)))?></div>
</article>
<?php  endif; ?>