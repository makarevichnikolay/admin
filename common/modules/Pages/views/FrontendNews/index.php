<?php
/* @var $this DefaultController */
if($category['parent_title']){
    $this->breadcrumbs=array(
        $category['parent_title']=>Yii::app()->createUrl('Pages/FrontendNews/index',array('category_id'=>$category['parent_id'])),
        $category['title'],
    );
}else{
    $this->breadcrumbs=array(
        $category['title']
    );
}

$this->title = $category['title'];
?>
<div class="new-content">
<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$model->search(),
    'itemView'=>'common.modules.Pages.views.frontendNews._new',
    'template'=>'{items}'
));
?>
</div>
<script type="text/javascript">
    var menuActive = '<?php echo $category['id'];?>';
    var menuParentActive = '<?php echo ($category['parent_id']!=0)?$category['parent_id']:'FALSE';?>';
    </script>