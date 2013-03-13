<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Вопросы голосований',
);
?>

<div class='admin-title-btn row-fluid'>
    <h2 class="span2">Вопросы голосований</h2>

    <div class="span2 offset8">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить',
            'icon' => 'icon-plus icon-white',
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => null, // null, 'large', 'small' or 'mini'
            'url' => array('AdminVotingQuestions/create')
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
            array(
                'name'=>'voting_id',
                'filter'=>CHtml::listData(Voting::model()->findAll(),'id','title'),
                'value'=>function($data){
                   return $data->voting->title;
                }
            ),
            'title',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update}{delete}',
                'buttons' => array(
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminVotingQuestions/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminVotingQuestions/delete", array("id" => $data['id'], "command" => "delete"));
                        },
                    ),
                ),
            ),
        ),

    )
);

