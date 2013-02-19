<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 15.02.13
 * Time: 12:25
 * To change this template use File | Settings | File Templates.
 */

?>
<article>
    <figure>
        <?php echo Chtml::image(Pages::getImageSrc('main_image','thumb',$data->id,$data->main_image)); ?>
        <figcaption>
            <time><?php echo date('d.m.Y',strtotime($data->date))?></time>
            <?php echo $data->title?>
        </figcaption>
    </figure>
    <div>
        <a href="#"><i class="css-icon css-icon-comment">1000</i></a>
        <i class="icon icon-eye-open"></i>
        <span>10000</span>
        <i class="icon icon-eye-open"></i>
        <a href="#" class="comment">Коментувати</a>
    </div>
</article>

