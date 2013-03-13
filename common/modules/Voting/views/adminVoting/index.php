<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Голосования',
);
?>

<div class='admin-title-btn row-fluid'>
    <h2 class="span2">Голосования</h2>

    <div class="span2 offset8">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить',
            'icon' => 'icon-plus icon-white',
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => null, // null, 'large', 'small' or 'mini'
            'url' => array('AdminVoting/create')
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
            'question_vote',
            'count_vote',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{voting_questions}{update}{delete}',
                'buttons' => array(
                    'voting_questions'=>array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminVotingQuestions/index", array("voting_id" => $data['id']));
                        },
                        'icon'=>'question-sign'
                    ),
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminVoting/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminVoting/delete", array("id" => $data['id'], "command" => "delete"));
                        },
                    ),
                ),
            ),
        ),

    )
);

