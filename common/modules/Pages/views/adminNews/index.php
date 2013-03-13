<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	'Новости',
);
?>

<?php
$dataFilter = $this->widget('zii.widgets.jui.CJuiDatePicker', array(
   // 'model' => $model,
    'name' => 'Pages[date_from]',
    'value'=>$model->date_from,
    'language' => 'ru',
   // 'mode' => 'datetime',
    'options' => array(
        'showOn' => 'focus',
        'showAnim'=>'fold',
        "dateFormat"=>'yy-mm-dd',
       // "timeFormat"=>'hh:mm:ss',
        'constrainInput' => 'false',
    ),
    'htmlOptions'=>array(
        'id'=>'date-datepicker-from',
        'class'=>'',
        'style'=>'width:75px;',
    ),
),true) . $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    //'model' => $model,
    'name' => 'Pages[date_to]',
    'value'=>$model->date_to,
    //'mode' => 'datetime',
    'language' => 'ru',
    'options' => array(
        'showOn' => 'focus',
        'showAnim'=>'fold',
        "dateFormat"=>'yy-mm-dd',
        // "timeFormat"=>'hh:mm:ss',
        'constrainInput' => 'false',
    ),
    'htmlOptions'=>array(
        'id'=>'date-datepicker-to',
        'class'=>'pull-right',
        'style'=>'width:75px;'
    ),
),true).'</div>'

?>
<div class='admin-title-btn row-fluid'>
    <h2 class="span2">Новости</h2>

    <div class="span2 offset8">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить',
            'icon' => 'icon-plus icon-white',
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'size' => null, // null, 'large', 'small' or 'mini'
            'url' => array('AdminNews/create')
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
        'afterAjaxUpdate' => 'reinstallDatePicker',
        'columns' => array(
            'title',
            array(
                'name'=>'categories',
                'filter'=> $this->widget('common.ext.EchMultiSelect.EchMultiSelect', array(
                    'model' => $model,
                    'dropDownAttribute' => 'categories',
                    'data' => CHtml::listData(Categories::model()->findAll(),'id','title'),
                    'options' => array(
                        'selectedList' => 1,
                        'ajaxRefresh'=>true
                    ),
                    'dropDownHtmlOptions' => array(
                           'style'=>'width:150px;'
                    ),
                ),true),
                'value'=>function($data){
                    $str = '';
                    if(isset($data->category)){
                        foreach($data->category as $val){
                            if (isset($val->category_name)) {
                                 $str .= $val->category_name->title.', ';
                            }                   
                        }
                    $str = mb_substr($str,0,(mb_strlen($str,'utf8')-2),'utf8');
                    }                 
                    return $str;
                },
                'htmlOptions' => array('style' => 'width:200px;'),
            ),
            array(
                'name' => 'date',
                'filter' => $dataFilter,
                'htmlOptions' => array('style' => 'width:200px;'),
            ),
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
                'class' => 'JToggleColumn',
                'name' => 'visible_on_main',
                'header'=>'Не публиковать в общей ленте',
                'filter' => array(0 => 'публиковать', 1 => 'не публиковать'),
                'buttonImageName' => 'ru-active-inactive-male',
                'checkedButtonLabel' => 'разрешено',
                'uncheckedButtonLabel' => 'запрещено',
                'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
            ),
            array(
                'class' => 'JToggleColumn',
                'name' => 'allow_comments',
                'filter' => array(0 => 'запрещено', 1 => 'разрешено'),
                'buttonImageName' => 'ru-active-inactive-male',
                'checkedButtonLabel' => 'разрешено',
                'uncheckedButtonLabel' => 'запрещено',
                'htmlOptions' => array('style' => 'text-align:center;width:100px;'),
            ),


            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{view}{comments}{update}{delete}',
                'buttons' => array(
                    'view' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->getModule("Pages")->createAbsoluteUrlF("Pages/FrontendNews/index", array("id" => $data['id']));
                        },
                    ),
                    'comments' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->createUrl('Comments/AdminComments/index',array('page_id'=>$data->id));
                        },
                        'icon'=>'comment'
                    ),
                    'update' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminNews/update", array("id" => $data['id']));
                        },
                    ),
                    'delete' => array(
                        'url' => function($data)
                        {
                            return Yii::app()->controller->createUrl("AdminNews/delete", array("id" => $data['id'], "command" => "delete"));
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
 $( '#date-datepicker-from' ).datepicker()
  $( '#date-datepicker-to' ).datepicker()
}
");