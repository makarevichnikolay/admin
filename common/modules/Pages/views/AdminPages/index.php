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
                    'title',
                    'url',
                     array(
                         'class' => 'JToggleColumn',
                         'name'=>'visible',
                         'filter'=>array(0=>'невидимый',1=>'видимый'),
                         'buttonImageName'=>'ru-active-inactive-male',
                         'checkedButtonLabel' => 'видимый',
                         'uncheckedButtonLabel' => 'невидимый',
                         'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
                     ),
                    array(
                        'class' => 'JToggleColumn',
                        'name'=>'allow_comments',
                        'filter'=>array(0=>'запрещено',1=>'разрешено'),
                        'buttonImageName'=>'ru-active-inactive-male',
                        'checkedButtonLabel' => 'разрешено',
                        'uncheckedButtonLabel' => 'запрещено',
                        'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
                    ),

                      
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