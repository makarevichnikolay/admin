<?php
/* @var $this AdminCategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Categories',
);


$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Создать',
    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => array('AdminCategories/create')
));

$this->widget(
    'common.ext.GroupGridView.BootGroupGridView',
    array(
        'type' => 'striped bordered condensed',
        'dataProvider' => $model->search(),
        'mergeColumns' => array('parent_id'),
        'filter' => $model,
        'template' => "{items}{pager}",
        'columns' => array(
            array(
                'name' => 'id',
                'htmlOptions' => array('style' => 'width:20px;'),
            ),
            array(
                'name' => 'parent_id',
                'header'=>'Родитель',
                'value'=>function($data){
                    if($data->parent){
                        return $data->parent->title;
                    }
                },
                'htmlOptions' => array('style' => 'width:200px;'),
            ),
            'title',
            'url',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update}{delete}',
                'buttons' => array(
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminCategories/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminCategories/delete", array("id" => $data['id'], "command" => "delete"));
                        },
                    ),
                ),
            ),
        ),

    )
);
