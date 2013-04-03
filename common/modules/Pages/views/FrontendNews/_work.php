<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 22.03.13
 * Time: 10:31
 * To change this template use File | Settings | File Templates.
 */
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$data->url));
?>
<article class="row-fluid work">
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo CHtml::link($data->title,$url)?></div>
                <span class="author"><?php  echo $data->author_name ?></span>
        </div>
    </div>
</article>