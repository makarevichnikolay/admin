<?php
/* @var $this AdminCategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Рубрики',
);
?>
<div class='admin-title-btn row-fluid'>
    <h2 class="span2">Рубрики</h2>

    <div class="span2 offset8">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить',
            'icon' => 'icon-plus icon-white',
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => null, // null, 'large', 'small' or 'mini'
            'url' => array('AdminCategories/create')
        ));
        ?>
    </div>
</div>
<?php
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
                'header' => 'Родитель',
                'value' => function($data)
                {
                    if ($data->parent) {
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
