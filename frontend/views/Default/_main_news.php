<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 15.02.13
 * Time: 12:25
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
?>
<article>
    <figure>
        <?php echo Chtml::image(Pages::getImageSrc('main_image','thumb',$data->id,$data->main_image),$data->title); ?>
        <figcaption>
            <time><?php echo date('d.m.Y',strtotime($data->date))?></time>
            <?php echo CHtml::link($data->title,$url)?>
        </figcaption>
    </figure>
    <div>
        <a href="<?php echo $url ?>"><i class="css-icon css-icon-comment">1000</i></a>
        <i class="icon-eye-open"></i>
        <span>10000</span>&nbsp
        <i class="icon-pen"></i><a href="<?php echo $url ?>" class="comment">Коментувати</a>
    </div>
</article>

