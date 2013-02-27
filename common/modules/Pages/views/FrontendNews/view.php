<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 27.02.13
 * Time: 13:37
 * To change this template use File | Settings | File Templates.
 */
$this->title = '';

    $this->breadcrumbs=array(
        //$category['parent'],
        //$category['children']
    );

?>
<div class="row-fluid new-view">
<div class="span12">
    <div class="row-fluid title">
        <?php if(!empty($model->author_image) && !empty($model->author_name)){?>
        <div class="span3">
            <div class="row-fluid">
                <div class="span4">
                    <?php echo CHtml::image(Pages::getImageSrc('author_image','thumb',$model->id,$model->author_image),$model->author_name,array('class'=>'author-image'))?>
                </div>
                <div class="span6 author-name">
                    <?php echo date('d.m.Y',strtotime($model->date)) ?><br />
                    <?php echo $model->author_name ?>
                </div>
            </div>
        </div>
        <div class="span8">
            <h3><?php echo $model->title ?></h3>
        </div>
        <?php }else{ ?>
        <div class="row-fluid">
            <div class="span3 author_name">
                <?php echo date('d.m.Y',strtotime($model->date)) ?>
            </div>
        </div>
            <div class="row-fluid">
                <div class="span9">
                    <h3><?php echo $model->title ?></h3>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row-fluid description">
        <div class="text">
        <?php echo CHtml::image(Pages::getImageSrc('main_image','new-view',$model->id,$model->main_image),$model->title,array('class'=>'main-image'))?>
        <?php echo $model->content;?>
        </div>
        <?php $this->widget('application.components.Widgets.newCarouselWidget',array('new_id'=>$model->id));?>
    </div>



</div>
</div>

