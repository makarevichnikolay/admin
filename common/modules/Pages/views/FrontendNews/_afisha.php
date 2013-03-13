<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 07.03.13
 * Time: 10:04
 * To change this template use File | Settings | File Templates.
 */

$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
if(isset($data->pageInfo)){
    $count_comments =$data->pageInfo->count_comments;
    $count_visited =$data->pageInfo->count_visited;
}else{
    $count_comments = $count_visited = 0;
}
?>
<article class="afisha">
    <figure>
        <?php echo CHtml::link(Chtml::image(Pages::getImageSrc('main_image','afisha',$data->id,$data->main_image)),$url) ?>
    </figure>
        <div class="content">
            <div class="title"><?php echo CHtml::link($data->title,$url)?></div>
        </div>
</article>