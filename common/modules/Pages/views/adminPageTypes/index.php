<?php
/* @var $this AdminPageTypesController */

$this->breadcrumbs=array(
	'Admin Page Types',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Создать',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
     'url'=>array('/Pages/AdminPageTypes/create')
));

$this->widget(
   'bootstrap.widgets.TbGridView',
    array(
       'type'=>'striped bordered condensed',
       'dataProvider'=>$model->search(),
       'filter' => $model,
       'template'=>"{items}",
       'columns'=>array(
       array(
           'name'=>'id',
            'htmlOptions'=>array('style'=>'width:20px;'),
       ),
       'title',
       'module',
       'controller',
       'action',
       'view',

    array(
       'class'=>'bootstrap.widgets.TbButtonColumn',
       'template'=>'{update}{delete}',
       'buttons'=>array(
          'update' => array(
                 'url'=>function($data){
                        return Yii::app()->controller->createUrl("AdminPageTypes/update", array("id"=>$data['id']));
                 },
          ),
          'delete' => array(
                  'url'=>function($data){
                      Yii::app()->controller->createUrl("AdminPageTypes/delete", array("id"=>$data['id'],"command"=>"delete"));
                  },
          ),
       ),
    ),
  ),
 )
);
