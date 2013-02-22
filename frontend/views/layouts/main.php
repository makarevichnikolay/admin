<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xml:lang="en" lang="en">
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
                <figure class="span3">
                     <img src="img/logo.png" alt="logo">
                </figure>
                <div class="span9 head-row">
                    <div class="row-fluid first-row">
                       <div class="span3">
                           <div class="row-fluid">
                               <i class="icon-calendar"></i><span id="date"></span>
                           </div>
                           <div class="row-fluid">
                               <i class="icon-time"></i><span id="time"></span>
                           </div>
                       </div>
                        <div class="span4">
                            <div class="row-fluid">
                                <div class="span3 tel-icon">
                                   <i class="icon-ok"></i>
                                </div>
                                <div class="span9">
                                    <div class="row-fluid caption">
                                        Гаряча лінія редакції
                                    </div>
                                    <div class="row-fluid tel">
                                       (0522) <span>12-34-56</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span4 offset1">
                            <?php
                            $modelSearch = new SearchWords('search');
                            $modelSearch->word = isset($_POST['SearchWords']) ? $_POST['SearchWords']['word'] : null;
                            $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                                'id' => 'searchForm',
                                'action' => array('/Search/Search/Search'),
                            )); ?>
                            <div class="input-append">
                                <?php echo $form->textField($modelSearch, 'word', array('class'=>'span10','placeholder'=>'Пошук')); ?>
                                <?php  $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submitLink', 'label' => '<i class="icon-search icon-white"></i>','encodeLabel'=>false))?>
                            </div
                            <?php $this->endWidget(); ?>
                        </div>
                    </div>
                    <div class="row-fluid second-row">
                          <div class="span7 slogon">
                              <h3>ТВІЙ ІНФОРМАЦІЙНИЙ ПРОСТІР...</h3>
                          </div>
                          <div class="span4  offset1 auth">
                              <div class="user">
                                  <a href="#">Вхід</a> <a>|</a> <a href="#">Реєстрація</a>
                              </div>
                              <div class="social"></div>
                          </div>
                    </div>
                </div>


            </div>
            <div class="row-fluid">
                <div class="span12">
                    <nav class="menu">
                        <?php echo Yii::app()->getModule('Menu')->getFrontendMenu(); ?>
                        <?php echo Yii::app()->getModule('Menu')->getFrontendMenu('second',6,7); ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <article class="row-fluid">
        <div class="span12">
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'homeLink'=>CHtml::link('Головна',array('/Default/index')),
        )); ?>
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
<footer class="footer">
    <div class="container-fluid main-container footer-container">
    </div>
</footer>
<div>
    <?php //echo Yii::powered(); ?>
</div>
</body>
</html>
