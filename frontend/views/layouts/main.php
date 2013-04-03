<?php
 $cacheTime = Yii::app()->params['Pages']['cacheTime'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/html" xml:lang="en" lang="en">
<head>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <?php Yii::app()->bootstrap->register(); ?>
    <?php
    $cs = Yii::app()->getClientScript();
    $cs->registerCoreScript('jquery');
    $cs->registerCoreScript('bbq');
    //Yii::app()->clientScript->registerCoreScript('jquery.ui');
    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/frontend.js', CClientScript::POS_END);
    $cs->registerCssFile(Yii::app()->baseUrl . '/css/styles.css');
    ?>


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

</head>

<body>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-39504842-1']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
<?php
Yii::app()->getModule('Banners');
$banner = Banners::getBanner(1);
if(!empty($banner)):
?>
<header class="navbar header">
    <div class="navbar-inner">
            <?php
            echo $banner;
            ?>
    </div>
</header>
<?php endif ?>
<section class="container-fluid main-container">

    <header class="row-fluid head">
        <div class="span12">
            <div class="row-fluid logo">
                <figure class="span3">
                     <a href="http://akulamedia.com"><img src="/img/logo.png"  alt="logo"></a>
                </figure>
                <div class="span9 head-row">
                    <div class="row-fluid first-row">
                       <div class="calendar">
                           <div class="row-fluid">
                               <i class="icon-calendar"></i><span id="date"></span>
                           </div>
                           <div class="row-fluid">
                               <i class="icon-time"></i><span id="time"></span>
                           </div>
                       </div>
                        <div class="phone">
                            <div class="row-fluid">
                                <div class="tel-icon">
                                   <i class="icon-tel"></i>
                                </div>
                                <div class="tel-caption">
                                    <div class="row-fluid caption">
                                        Гаряча лінія редакції
                                    </div>
                                    <div class="row-fluid tel">
                                        (095)<span>777-577-8</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="social">
                            <a class="fb" href="http://www.facebook.com/groups/436311916451248/"></a>
                            <a class="vk" href="http://vk.com/id203640707"></a>
                            <a class="tw" href="https://twitter.com/akulamedia"></a>
                            <a class="od" href="http://www.odnoklassniki.ru/profile/557413749122"></a>
                        </div>

                    </div>
                    <div class="row-fluid second-row">
                          <div class="span7 slogon">
                              <h3>ТВІЙ ІНФОРМАЦІЙНИЙ ПРОСТІР</h3>
                          </div>
                        <div class="span4 offset1 search">
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
                            </div>
                            <?php $this->endWidget(); ?>
                        </div>

                    </div>
                    <div class="row-fluid third-row">
                        <div class="span4  offset8 auth">
                            <div class="user">
                                <?php  $this->renderPartial('common.modules.Users.views.users._login',null,false,false)?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="row-fluid">
                <div class="span12">
                    <nav class="menu">
                        <?php
                        if($this->beginCache('menu', array('duration'=>$cacheTime))) {
                            echo Yii::app()->getModule('Menu')->getFrontendMenu();
                            echo Yii::app()->getModule('Menu')->getFrontendMenu('second',7,7);
                            $this->endCache(); }
                        ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <?php if(!empty($this->breadcrumbs)): ?>
    <article class="row-fluid">
        <div class="span12">
            <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'separator'=>'>',
            'homeLink'=>CHtml::link('Головна',array('/Default/index')),
        )); ?>
        </div>
    </article>
    <?php endif; ?>
    <?php if(!empty($this->title)): ?>
    <article class="row-fluid">
        <div class="span12">
            <h3 class="page-title"><i class="icon-paper"></i> <?php echo $this->title ?></h3>
        </div>
    </article>
    <?php endif ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="row-fluid">
                <section class="span9 content">
                    <?php echo $content; ?>
                    <div class="row-fluid">
                        <?php
                        echo Banners::getBanner(3);
                        ?>
                    </div>
                </section>
                <aside class="span3 right-column">
                        <?php
                          $banner = Banners::getBanner(4);
                          if(!empty($banner)):
                        ?>
                        <div class="row-fluid">
                            <?php
                            echo $banner;
                            ?>
                        </div>
                        <?php endif;?>
                        <div class="row-fluid">
                            <?php
                            if($this->beginCache('photo_new', array('duration'=>$cacheTime))) {
                                $this->widget('application.components.Widgets.photoNewWidget');
                                $this->endCache(); }
                            ?>
                        </div>
                        <div class="row-fluid">
                            <?php
                            if($this->beginCache('video_new', array('duration'=>$cacheTime))) {
                                $this->widget('application.components.Widgets.videoNewWidget');
                                $this->endCache(); }
                            ?>
                        </div>
                        <?php
                          $banner = Banners::getBanner(5);
                          if(!empty($banner)):
                        ?>
                        <div class="row-fluid">
                            <?php
                            echo $banner;
                            ?>
                        </div>
                        <?php endif;?>
                        <?php
                           $banner = Banners::getBanner(6);
                            if(!empty($banner)):
                        ?>
                        <div class="row-fluid">
                            <?php
                            echo $banner;
                            ?>
                        </div>
                        <?php endif;?>
                        <div class="row-fluid" id="voting-container">
                            <?php
                               $this->widget('application.components.Widgets.votingWidget');
                            ?>
                        </div>
                </aside>
            </div>

        </div>
    </div>
    <?php
      $partner=Banners::getBanner(8);
      if(!empty($partner)):
    ?>
    <div class="row-fluid partners">
        <?php
        echo $partner;
        ?>
    </div>
        <?php endif ?>
</section>
<footer class="footer">
    <div class="container-fluid main-container footer-container">
        <div class="row-fluid">
            <div class="span12 text">
                <?php
                echo Banners::getBanner(7);
                ?>
            </div>
        </div>
        <div class="row-fluid  info">
            <div class="span2">
                <div class="copy">
                    &copy akulamedia.com
                </div>
            </div>
            <div class="span3 footermenu">
               <?php  echo Yii::app()->getModule('Menu')->getFooterMenu();?>
            </div>
            <div class="span2 code">
                <!--bigmir)net TOP 100-->
                <script type="text/javascript" language="javascript"><!--
                function BM_Draw(oBM_STAT){
                    document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="margin:0px;padding:0px;font-size:1px;width:88px;"><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b59_top.gif\') no-repeat bottom;"> </div><div style="font:10px Tahoma;background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b59_center.gif\');"><div style="text-align:center;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;font:10px Tahoma;">bigmir<span style="color:#ff0000;">)</span>net</a></div><div style="margin-top:3px;padding: 0px 6px 0px 6px;color:#003596;"><div style="float:left;font:10px Tahoma;">'+oBM_STAT.hosts+'</div><div style="float:right;font:10px Tahoma;">'+oBM_STAT.hits+'</div></div><br clear="all"/></div><div style="background:url(\'http://i.bigmir.net/cnt/samples/diagonal/b59_bottom.gif\') no-repeat top;"> </div></div></td></tr></table>');
                }
                //-->
                </script>
                <script type="text/javascript" language="javascript"><!--
                bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16919896,s:16919896,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
                for(var f=self;f!=f.parent;f=f.parent)bm.w++;
                try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
                else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
                try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
                try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
                r=bmD.referrer.slice(7);if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r).slice(0,400);bm.v^=r.length}
                bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
                bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="http://c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');
                //-->
                </script>
                <noscript>
                    <a href="http://www.bigmir.net/" target="_blank"><img src="http://c.bigmir.net/?v16919896&s16919896&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
                </noscript>
                <!--bigmir)net TOP 100-->
            </div>
            <div class="span2 offset3 onix">
                <figure class=""><a href="http://www.onix.ua" target="_blank"><img src="frontend/www/img/onix.png"></a></figure>
            </div>
        </div>
    </div>
</footer>
<div>
    <?php //echo Yii::powered(); ?>
</div>
</body>
</html>
