<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
    <?php Yii::app()->bootstrap->register(); ?>
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    //Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/frontend.js', CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/frontend.js', CClientScript::POS_END);
    $cs->registerCssFile(Yii::app()->baseUrl.'/css/styles.css');
    ?>


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>


<header class="navbar header">
    <div class="navbar-inner">
    </div>
</header>
<section class="container main-container">
    <header class="row-fluid head"">
        <div class="row-fluid">
            <div class="span12">
                Logo
            </div>
        </div>

        <nav class="row-fluid menu">
            <div class="span12">
                menu
            </div>
        </nav>
    </header>
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <div class="span9">
                    <div class="row-fluid main-news">

                    </div>
                </div>
                <aside class="span3">
                    <div class="row-fluid main-news">

                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<footer class="navbar footer">
    <div class="navbar-inner">
    </div>
</footer>
<div>
    <?php //echo Yii::powered(); ?>
</div>
</body>
</html>
