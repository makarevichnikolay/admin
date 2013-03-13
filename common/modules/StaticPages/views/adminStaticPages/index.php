<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Новости',
);
?>

<div class='admin-title-btn row-fluid'>
    <h2 class="span2">Статические страницы</h2>

    <div class="span2 offset8">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить',
            'icon' => 'icon-plus icon-white',
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => null, // null, 'large', 'small' or 'mini'
            'url' => array('AdminStaticPages/create')
        ));
        ?>
    </div>
</div>


<?php
$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'type' => 'striped bordered condensed hover',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'ajaxUpdate' => true,
        'template' => "{items}{pager}",
        'columns' => array(
            'title',
            array(
                'class' => 'JToggleColumn',
                'name' => 'visible',
                'filter' => array(0 => 'невидимый', 1 => 'видимый'),
                'buttonImageName' => 'ru-active-inactive-male',
                'checkedButtonLabel' => 'видимый',
                'uncheckedButtonLabel' => 'невидимый',
                'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
            ),


            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => array(
                    'view' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->getModule("StaticPages")->createAbsoluteUrlF("StaticPages/FrontendStaticPages/view", array("id" => $data['id']));
                        },
                    ),
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminStaticPages/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminStaticPages/delete", array("id" => $data['id'], "command" => "delete"));
                        },
                    ),
                ),
            ),
        ),

    )
);

