<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 18.02.13
 * Time: 15:12
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
?>
<article class="row-fluid new">
    <figure class="left-block">
        <?php echo CHtml::link(Chtml::image(Pages::getImageSrc('main_image','thumb2',$data->id,$data->main_image)),$url) ?>
    </figure>
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo CHtml::link($data->title,$url)?></div>
            <div class="description"><?php echo Helper::cutStr($data->content,280)?></div>
        </div>
        <div class="info-bar">
            <time><?php echo date('d.m.Y',strtotime($data->date))?></time>
            <a href="<?php echo $url ?>"><i class="css-icon css-icon-comment">1000</i></a>
            <i class="icon icon-eye-open"></i>
            <span>10000</span>
            <i class="icon icon-eye-open"></i>
            <a href="<?php echo $url ?>" class="comment">Коментувати</a>
        </div>
    </div>
</article>