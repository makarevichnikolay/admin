<?php
  $item_data = SearchController::getItemData($data['item_id'],$data['words']);
if($item_data):
$url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$item_data['url']));
?>
<article class="row-fluid new">
    <figure class="left-block">
        <?php echo CHtml::link(Chtml::image(Pages::getImageSrc('main_image','thumb2', $item_data['id'], $item_data['main_image'])),$url) ?>
    </figure>
    <div class="right-block">
        <div class="content">
            <div class="title"><?php echo CHtml::link($item_data['title'],$url)?></div>
            <div class="description"><?php echo  $item_data['body']?></div>
        </div>
    </div>
</article>
<?php endif; ?>