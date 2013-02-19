<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 18.02.13
 * Time: 15:12
 * To change this template use File | Settings | File Templates.
 */
?>
<article class="row-fluid new">
    <figure class="left-block">
        <?php echo Chtml::image(Pages::getImageSrc('main_image','thumb2',$data->id,$data->main_image)); ?>
    </figure>
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo $data->title?></div>
            <div class="description"><?php echo $data->content?></div>
        </div>
        <div class="info-bar">
            <time><?php echo date('d.m.Y',strtotime($data->date))?></time>
            <a href="#"><i class="css-icon css-icon-comment">1000</i></a>
            <i class="icon icon-eye-open"></i>
            <span>10000</span>
            <i class="icon icon-eye-open"></i>
            <a href="#" class="comment">Коментувати</a>
        </div>
    </div>
</article>