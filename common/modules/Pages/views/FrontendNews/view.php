<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 27.02.13
 * Time: 13:37
 * To change this template use File | Settings | File Templates.
 */
$this->title = '';

    $this->breadcrumbs=$category['parent'];

$cs = Yii::app()->getClientScript();
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.fancybox.js', CClientScript::POS_HEAD);
$cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.json2html-3.1-min.js', CClientScript::POS_HEAD);
$src = Pages::getImageSrc('author_image','thumb',$model->id,$model->author_image);
?>
<div class="row-fluid new-view">
<div class="span12">
    <div class="row-fluid title">
        <?php if(!empty($model->author_image) && !empty($model->author_name)){?>
        <div class="span3">
            <div class="row-fluid">
                <div class="span4">
                    <?php echo CHtml::image($src,$model->author_name,array('class'=>'author-image'))?>
                </div>
                <div class="span6 author-name">
                    <?php echo date('d.m.Y',strtotime($model->date)) ?><br />
                    <?php echo $model->author_name ?>
                </div>
            </div>
        </div>
        <div class="span8">
            <h3><?php echo $model->title ?></h3>
        </div>
        <?php }else{ ?>
        <div class="row-fluid">
            <div class="span3 author_name">
                <?php echo date('d.m.Y',strtotime($model->date)) ?>
            </div>
        </div>
            <div class="row-fluid">
                <div class="span9">
                    <h3><?php echo $model->title ?></h3>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row-fluid description">
        <div class="span12">
            <div class="row-fluid text">
                <?php
                if(in_array(7,$cur_category_ids)){
                    echo $model->video;
                }else{
                    echo CHtml::link(
                        CHtml::image(Pages::getImageSrc('main_image','new-view',$model->id,$model->main_image),$model->title,array('class'=>'main-image')),
                        Pages::getImageSrc('main_image','large',$model->id,$model->main_image),
                        array(
                            'class'=>'fancybox',
                            'title'=>$model->title,
                        )
                    );
                }

                ?>
                <?php echo $model->content;?>
            </div>
            <div class="row-fluid">
                <?php
                    $this->widget('application.components.Widgets.newCarouselWidget',array('new_id'=>$model->id));
                ?>
            </div>
            <div class="row-fluid">
                <div class="info-bar">
                    <?php $url = Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$model->url));?>
                    <a href="<?php echo $url ?>"><i class="css-icon css-icon-comment"><?php echo $pageInfo->count_comments ?></i></a>
                    <i class="icon-eye-open"></i>
                    <span><?php echo $pageInfo->count_visited ?></span>&nbsp
                    <i class="icon-pen"></i><a id="to-comment" href="<?php echo $url ?>" class="comment">Коментувати</a><span id="not-login"></span>
                </div>
                <div class="social">
                    <div class="share42init" data-path="img/" data-title="<?php echo $model->title ?>" data-image="<?php echo 'http://'.$src ?>"></div>
                    <?php
                    $cs = Yii::app()->getClientScript();
                    $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/share42.js', CClientScript::POS_END);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row-fluid">
    <div class="span12">
        <h4>Коментарі:</h4>
    </div>
</div>
<div class="row-fluid" >
    <div class="span12" id="comments">

    </div>
</div>
    <?php if(!Yii::app()->user->isGuest && !Yii::app()->user->banned && $model->allow_comments): ?>
<div class="row-fluid send-comment">
    <div class="span12">
        <div class="row-fluid header">
            <div class="span12">
               <h4>Коментувати</h4>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <textarea maxlength="240" class="span12" id="text-comment" rows="10" cols=""></textarea>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <a id="send-comment" href="#" class="span2 main-btn">Відповісти</a>
            </div>
        </div>
    </div>
</div>
    <?php endif;?>
    <script type="text/javascript">
        var page_id = <?php echo $model->id ?>;
        var userLogin = <?php echo (Yii::app()->user->isGuest)?0:1 ?>;
        $(document).ready(function() {
            $(".fancybox").fancybox({
                openEffect	: 'none',
                closeEffect	: 'none',
                prevEffect	: 'none',
                nextEffect	: 'none'
            });
            $('#send-comment').on('click',function(){
                sendComment();
                return false;
            });
            $('#to-comment').live('click',function(){
                if(userLogin){
                    $('.send-comment').scrollToMe();
                }else{
                    $('.user').scrollToMe();
                    $('.login-form').show();
                }
                return false;
            });
        });
        var canSend = true;


        var transforms = {
            comment: [
                {tag:'article',class:'row-fluid comment',children:[
                    {tag:'div',class:'span12',children:[
                        {tag:'div',class:'row-fluid header',children:[
                            {tag:'div',class:'span12',children:[
                                {tag:'i',class:'icon-user'},
                                {tag:'span',html:'${nickname}'},
                                {tag:'time',html:'${date}'}
                            ]}
                        ]},
                        {tag:'div',class:'row-fluid',children:[
                            {tag:'div',class:'span12 content',html:'${content}'}
                        ]}
                    ]}
                ]}
            ],
            comment_new: [
                {tag:'article',class:'row-fluid comment',children:[
                    {tag:'div',class:'span12',children:[
                        {tag:'div',class:'row-fluid header',children:[
                            {tag:'div',class:'span12',children:[
                                {tag:'i',class:'icon-user'},
                                {tag:'span',html:'${nickname}'},
                                {tag:'time',html:'${date}'}
                            ]}
                        ]},
                        {tag:'div',class:'row-fluid',children:[
                            {tag:'div',class:'span12 content  comment-new',html:'${content}'}
                        ]}
                    ]}
                ]}
            ]
        };
        (function(){
            getComments(transforms.comment);
            setTimeout(function(){
                if($.bbq.getState( 'comment', true )){
                    if(userLogin){
                        $('.send-comment').scrollToMe();
                    }else{
                        $('.user').scrollToMe();
                        $('.login-form').show();
                    }
                };
            },1000);
           setInterval(function(){
               getComments(transforms.comment_new);
           },10000)
        })();


        function sendComment(){
            var text = $('#text-comment').val();
            var data = {'page_id':page_id,'text':text};
            $.ajax({
                type: "POST",
                url: '<?php echo $this->createUrl('/Comments/FrontendComments/saveComment') ?>',
                data:data,
                dataType:'json',
                beforeSend : function(xhr, opts){
                    if(!canSend) {
                        xhr.abort();
                    }
                    canSend = false;
                }
            }).done(function( data ) {
                    getComments(transforms.comment_new);
                    $('#text-comment').val('');
                    canSend = true;
                });
        }

        var lastComment;
        function getComments(transform_type){
            if(lastComment){
                var data ={'id':lastComment['id'],'page_id':page_id} ;
            }else{
                var data = {'id':false,'page_id':page_id};
            }
            $.ajax({
                type: "POST",
                url: '<?php echo $this->createUrl('/Comments/FrontendComments/GetCommentJSON') ?>',
                data:data,
                dataType:'json'
            }).done(function( data ) {
                    if(data.length > 0){
                        $('#comments').json2html(data,transform_type);
                        lastComment = data[data.length - 1];
                        setTimeout(function(){
                            $('.comment-new').removeClass('comment-new');
                        },500);
                    }
                    var canSend = false;
                });
        }


    </script>

