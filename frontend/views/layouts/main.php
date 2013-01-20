<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/site/index')),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>1))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>100))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>789))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>2887))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>5889))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>1900))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>8900))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>456))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>4567))),
                array('label'=>'test', 'url'=>$this->createUrl('/Pages/FrontendPages/index',array('id'=>5678))),
            ),
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
