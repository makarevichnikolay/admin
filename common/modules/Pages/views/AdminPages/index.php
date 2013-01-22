<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>



<?php
 $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Создать',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
     'url'=>array('AdminPages/create')
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
                    array(
                        'header'=>'Тип',
                       'name'=>'type_id',
                       'value'=>function($data){
                                // return $data->type->title;
                                }
                    ),
                    'title',
                    'url',
                      
                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{update}{delete}',
                        'buttons'=>array(
                                'view' => array(
                                    'url'=>function($data){
                                        return Yii::app()->getModule("Pages")->createAbsoluteUrlF("Pages/FrontendPages/index", array("id"=>$data['id']));
                                    },
                                ),
                                'update' => array(
                                  'url'=>function($data){
                                      return Yii::app()->controller->createUrl("AdminPages/update", array("id"=>$data['id']));
                                  },
                                ),
                                'delete' => array(
                                  'url'=>function($data){
                                      return Yii::app()->controller->createUrl("AdminPages/delete", array("id"=>$data['id'],"command"=>"delete"));
                                  },
                                ),
                        ),
                    ), 
    	         ),

            )
        );