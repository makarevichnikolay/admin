<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
     $category['title']
);
?>
<?php
$this->widget('bootstrap.widgets.TbListView', array(
    'dataProvider'=>$model->search(),
    'itemView'=>'common.modules.Pages.views.FrontendNews._new',
    'template'=>'{items}'
));
?>
<script type="text/javascript">
    var menuActive = '<?php echo $category['id'];?>';
    var menuParentActive = '<?php echo ($category['parent_id']!=0)?$category['parent_id']:'FALSE';?>';
    </script>