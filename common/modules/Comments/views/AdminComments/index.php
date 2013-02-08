<?php
$this->breadcrumbs=array(
'Users',
);
?>

<h1>Users</h1>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Все пользователи',
    'type' => 'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => array('AdminComments/',array('user_id'=>null,'page_id'=>$model->page_id))
));
?>
&nbsp
<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Все новости',
    'type' => 'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size' => 'large', // null, 'large', 'small' or 'mini'
    'url' => array('AdminComments/',array('user_id'=>$model->user_id,'page_id'=>null))
));
?>
<?php
$dataFilter = $this->widget('common.ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
    // 'model' => $model,
    'name' => 'Comments[date_from]',
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
    'name' => 'Comments[date_to]',
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

$this->widget(
    'bootstrap.widgets.TbGridView',
    array(
        'type' => 'striped  condensed hover',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'ajaxUpdate' => true,
        'template' => "{items}{pager}",
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => array(
            'content',
            array(
                'name'=>'user_id',
                'type'=>'html',
                'filter'=>false,
                'value'=>function($data){
                             if(isset($data->user) && isset($data->user->id))
                                return CHtml::link($data->user->nickname,Yii::app()->createUrl('Comments/AdminComments/index',array('user_id'=>$data->user_id)));
                             else
                                return 'Такого пользователя нет';
                         }
            ),
            array(
                'name'=>'user_id',
                'header'=>'ip',
                'type'=>'html',
                'filter'=>false,
                'value'=>function($data){
                    if(isset($data->user) && isset($data->user->id))
                        return $data->user->ip;
                    else
                        return '-';
                }
            ),
            array(
                'name'=>'page_id',
                'type'=>'html',
                'filter'=>false,
                'value'=>function($data){
                    if(isset($data->page) && isset($data->page->id))
                        return CHtml::link($data->page->title,Yii::app()->createUrl('Comments/AdminComments/index',array('page_id'=>$data->page_id)));
                    else
                        return 'Такой записи нет';
                }
            ),
            array(
                'name' => 'date_create',
                'filter' => $dataFilter,
                'htmlOptions' => array('style' => 'width:150px;'),
            ),

            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{user}{delete}',
                'buttons' => array(
                    'user' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->createUrl('Users/AdminUsers/update',array('id'=>$data->user->id));
                        },
                        'icon'=>'user'
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminComments/delete", array("id" => $data['id'], "command" => "delete"));
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