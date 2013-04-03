<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 07.03.13
 * Time: 11:22
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
?>
<article class="row-fluid dose">
    <figure class="left-block">
        <?php echo CHtml::link(Chtml::image(Pages::getImageSrc('main_image','thumb',$data->id,$data->main_image)),$url) ?>
    </figure>
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo CHtml::link($data->title,$url)?></div>
        </div>

    </div>
</article>