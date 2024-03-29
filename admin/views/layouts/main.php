<?php /* @var $this Controller */
$cs = Yii::app()->getClientScript();
$cs->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.nestable.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.json2html-3.1-min.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/admin.js', CClientScript::POS_END);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/styles.css" />
</head>

<body>

<?php
$menu = Yii::app()->getModule('Menu')->getMenu();

$this->widget('bootstrap.widgets.TbNavbar', array(
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $menu,
        ),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items' => array(
                array('label' => Yii::app()->user->name, 'url' => '#','items'=>array(
                    array('label' => 'Выйти', 'url' => Yii::app()->createUrl('Users/AdminUsers/Logout')),
                )),
            ),
        ),
    )));
/*array(
array('label'=>'Модули' ,'items'=>array(
array('label'=>'Страницы', 'items'=>array(
array('label'=>'Список страниц','url'=>array('/Pages/AdminPages/index')),
array('label'=>'Типы страниц','url'=>array('/Pages/AdminPageTypes/index'))
),
),
),
),
array('label'=>'Структура сайта', 'items'=>array(
array('label'=>'Меню - 1', 'url'=>array('/Menu/AdminMenu/index')),
),

),
),*/
?>

<div class="container main" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
        <div class="pull-left">&copy; Акула</div>
		<figure class="pull-right"><a href="http://www.onix.ua" target="_blank"><img src="/admin/www/img/onix.png"></a></figure>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
