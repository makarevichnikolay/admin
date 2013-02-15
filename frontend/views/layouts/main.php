<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <?php Yii::app()->bootstrap->register(); ?>
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    //Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/frontend.js', CClientScript::POS_END);
    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/frontend.js', CClientScript::POS_END);
    $cs->registerCssFile(Yii::app()->baseUrl . '/css/styles.css');
    ?>


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>


<header class="navbar header">
    <div class="navbar-inner">
    </div>
</header>

<section class="container-fluid main-container">

    <header class="row-fluid head">
        <div class="span12">
            <div class="row-fluid logo">
                <div class="span12">
                    Logo
                    <div class="pull-right">
                        <?php
                        $modelSearch = new SearchWords('search');
                        $modelSearch->word = isset($_POST['SearchWords']) ? $_POST['SearchWords']['word'] : null;
                        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                            'id' => 'searchForm',
                            'type' => 'search',
                            'htmlOptions' => array('class' => 'well'),
                            'action' => array('/Search/Search/Search'),
                        )); ?>
                        <?php echo $form->textFieldRow($modelSearch, 'word', array('class' => 'input-medium', 'prepend' => '<i class="icon-search"></i>')); ?>
                        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'label' => 'Go')); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>


            <nav class="row-fluid menu">
                <div class="span12">
                    <ul class="first">
                        <li>Test</li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <article class="row-fluid breadcrumbs">
        <div class="span12">
            <?php echo $this->breadcrumbs;?>
        </div>
    </article>

    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <section class="span9 content">
                    <?php echo $content; ?>
                </section>
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
