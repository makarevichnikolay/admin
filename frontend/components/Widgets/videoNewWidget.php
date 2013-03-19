<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 26.02.13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */

class videoNewWidget extends CWidget{

    public $header = 'Відео новина';

    public function run() {
        $criteria= new CDbCriteria();
        $criteria->limit = 1;
        $criteria->compare('video_new',1);
        //$criteria->addCondition('video != ""');
        $criteria->order = 'date DESC';
        $page = Pages::model()->find($criteria);
        if($page){
            $data = '';
            $data .= CHtml::openTag('div',array('class'=>'photo-new'));
            $data .= CHtml::openTag('div',array('class'=>'head'));
            $data .= CHtml::openTag('i',array('class'=>'photo'));
            $data .= CHtml::closeTag('i');
            $data .=CHtml::link(
                $this->header,
                Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$page->url))
            );
            $data .= CHtml::closeTag('div');
            $data .= CHtml::openTag('figure');
            $data .= CHtml::link(
                CHtml::image(Pages::getImageSrc('main_image','photo-new',$page->id,$page->main_image),$page->title),
                Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$page->url))
            );
            $data .= CHtml::openTag('figcaption');
            $data.=CHtml::link(
                $page->title,
                Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$page->url))
            );
            $data .= CHtml::closeTag('figcaption');
            $data .= CHtml::closeTag('figure');
            $data .= CHtml::closeTag('div');
            echo $data;
            /*$data = '';
            $data .= CHtml::openTag('div',array('class'=>'photo-new'));
                $data .= CHtml::openTag('div',array('class'=>'head'));
                    $data .= CHtml::openTag('i',array('class'=>'video'));
                    $data .= CHtml::closeTag('i');
                    $data .=CHtml::link(
                        $this->header,
                        Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$page->url))
                    );
                $data .= CHtml::closeTag('div');
                $data .= CHtml::openTag('figure');
                    $data .= CHtml::openTag('div');
                        $data .= $page->video;
                    $data .= CHtml::closeTag('div');
                    $data .= CHtml::openTag('figcaption');
                         $data.=CHtml::link(
                             $page->title,
                             Yii::app()->createUrl('Pages/FrontendNews/view',array('url'=>$page->url))
                         );
                    $data .= CHtml::closeTag('figcaption');
                $data .= CHtml::closeTag('figure');
            $data .= CHtml::closeTag('div');
            echo $data;*/
        }
    }
}
?>