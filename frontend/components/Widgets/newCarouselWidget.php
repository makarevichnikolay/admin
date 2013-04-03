<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 27.02.13
 * Time: 17:19
 * To change this template use File | Settings | File Templates.
 */
class newCarouselWidget extends CWidget
{
    public $new_id;
    public $class = 'newCarousel';

    public function run()
    {
        if($this->new_id){
            $images = PagesImages::model()->findAll('page_id = :page_id',array(':page_id'=>$this->new_id));
            if(!empty($images)){
                $data = '';
                $data .= CHtml::openTag('div',array('class'=>'jcarousel-wrapper'));
                $data .= CHtml::openTag('div',array('class'=>$this->class));
                $data .= CHtml::openTag('ul');
                foreach($images as $val){
                    $data .= CHtml::openTag('li');
                    $data .= CHtml::link(
                        CHtml::image(PagesImages::getImageSrc($this->new_id,$val->id,$val->file_name),$val->title),
                        PagesImages::getImageSrc($this->new_id,$val->id,$val->file_name,'large'),
                        array(
                            'class'=>'fancybox',
                            'title'=>$val->title,
                            'rel'=>'fancybox-button'
                        )
                    );
                    $data .= CHtml::closeTag('li');
                }
                $data .= CHtml::closeTag('ul');
                $data .= CHtml::closeTag('div');
                $data .= CHtml::link('','#9',array('class'=>"jcarousel-prev"));
                $data .= CHtml::link('','#',array('class'=>"jcarousel-next"));
                $data .= CHtml::closeTag('div');
                echo $data;
                $cs = Yii::app()->getClientScript();
                $cs->registerScriptFile(Yii::app()->request->baseUrl . '/js/jquery.jcarousel.min.js', CClientScript::POS_HEAD);
                $cs->registerScript('newCarousel', '
         $(document).ready(function () {
            $(".'.$this->class.'").jcarousel({

            });
            $(".jcarousel-prev").jcarouselControl({
                target: "-=1"
             });
             $(".jcarousel-next").jcarouselControl({
                  target: "+=1"
             });
         })', CClientScript::POS_READY);
            }

        }


    }


}