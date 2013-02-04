<?php
/* @var $this AdminUsersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Users',
);

$this->menu=array(
	array('label'=>'Create Users', 'url'=>array('create')),
	array('label'=>'Manage Users', 'url'=>array('admin')),
);
?>

<h1>Users</h1>

<?php
$dataFilter = $this->widget('common.ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
    // 'model' => $model,
    'name' => 'Users[date_from]',
    'value'=>$model->date_from,
    'language' => 'ru',
    'mode' => 'datetime',
    'options' => array(
        'showOn' => 'focus',
        'showAnim'=>'fold',
        "dateFormat"=>'yy-mm-dd',
         "timeFormat"=>'hh:mm:ss',
       // 'constrainInput' => 'false',
    ),
    'htmlOptions'=>array(
        'id'=>'date-datepicker-from',
        //'class'=>'',
        'style'=>'width:135px;',
    ),
),true) . $this->widget('common.ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
    //'model' => $model,
    'name' => 'Users[date_to]',
    'value'=>$model->date_to,
    'mode' => 'datetime',
    'language' => 'ru',
    'options' => array(
        'showOn' => 'focus',
        'showAnim'=>'fold',
        "dateFormat"=>'yy-mm-dd',
        "timeFormat"=>'hh:mm:ss',
       // 'constrainInput' => 'false',
    ),
    'htmlOptions'=>array(
        'id'=>'date-datepicker-to',
       // 'class'=>'',
        'style'=>'width:135px;margin-top:4px;'
    ),
),true).'</div>'

?>

<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label'=>'Создать',
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'large', // null, 'large', 'small' or 'mini'
    'url'=>array('AdminUsers/create')
));

$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'type' => 'striped bordered condensed hover',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'ajaxUpdate' => true,
        'template' => "{items}{pager}",
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => array(
            'login',
            'nickname',
            'ip',
            array(
                'name'=>'role_id',
                'filter'=>CHtml::listData( UsersRole::model()->findAll(),'id','description'),
                'value'=>function($data){
                       return  $data->role->description;
                }
            ),
            array(
                'name' => 'last_visited',
                'filter' => $dataFilter,
                'htmlOptions' => array('style' => 'width:150px;'),
            ),
            array(
                'class' => 'JToggleColumn',
                'name' => 'baned',
                'filter' => array(0 => 'Незабанен', 1 => 'Забанен'),
                'buttonImageName' => 'ru-active-inactive-male',
                'checkedButtonLabel' => 'разрешено',
                'uncheckedButtonLabel' => 'запрещено',
                'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{update}{delete}',
                'buttons' => array(
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminUsers/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminUsers/delete", array("id" => $data['id'], "command" => "delete"));
                        },
                    ),
                ),
            ),
        ),

    )
);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
 $.datepicker.setDefaults($.datepicker.regional['ru']);
 $( '#date-datepicker-from' ).datetimepicker({dateFormat:'yy-mm-dd','timeFormat':'hh:mm:ss'})
  $( '#date-datepicker-to' ).datetimepicker({dateFormat:'yy-mm-dd','timeFormat':'hh:mm:ss'})
}
");
