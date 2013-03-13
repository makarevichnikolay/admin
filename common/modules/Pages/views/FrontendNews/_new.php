<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 18.02.13
 * Time: 15:12
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
<article class="row-fluid new">
    <figure class="left-block">
        <?php echo CHtml::link(Chtml::image(Pages::getImageSrc('main_image','thumb2',$data->id,$data->main_image)),$url) ?>
    </figure>
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo CHtml::link($data->title,$url)?></div>
            <div class="author"><?php echo $data->category_one->category_name->title ?></div>
            <div><time><?php echo date('d.m.Y',strtotime($data->date))?></time>
                <span class="author"><?php  echo $data->author_name ?></span>
            </div>
            <div class="description"><?php echo Helper::cutStr(strip_tags($data->content),280)?></div>
        </div>
        <div class="info-bar">
            <a href="<?php echo $url ?>"><i class="css-icon css-icon-comment"><?php echo $count_comments  ?></i></a>
            <i class="icon-eye-open"></i>
            <span><?php echo $count_visited  ?></span>&nbsp
            <i class="icon-pen"></i><a href="<?php echo $url.'#comment=1' ?>" class="comment">Коментувати</a>
        </div>
    </div>
</article>