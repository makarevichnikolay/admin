<?php

class RssController extends FrontendController
{


    public function actionIndex()
    {
        Yii::import('common.ext.feed.*');
        $feed = new EFeed();

        $feed->title= 'akulamedia.com Кіровоградський медіапортал';
        $feed->description = 'akulamedia.com ТВІЙ ІНФОРМАЦІЙНИЙ ПРОСТІР';

        $feed->setImage('icon','http://akulamedia.com',
            'http://akulamedia.com/data/favicon.ico');

        //$feed->addChannelTag('language', 'en-us');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', 'http://akulamedia.com/rss' );

        $feed->addChannelTag('link','http://akulamedia.com/rss');
        $pages = Pages::model()->findAllByAttributes(array('visible'=>1),array('limit'=>15,'order'=>'date DESC'));
        foreach($pages as $val){
            $item = $feed->createNewItem();
            $item->title = $val->title;
            $item->link = Yii::app()->createAbsoluteUrl($val->url);
            $item->date = strtotime($val->date);
            if(!empty($val->main_image)){
                $item->description =  CHtml::image(Pages::getImageSrc('main_image','new-view',$val->id,$val->main_image),$val->title,array('style'=>'float:left;margin:0 5px 5px 0')).
                    $val->content;
            }else{
                 $item->description = $val->content;
            }

            //$item->setEncloser('http://www.tester.com', '1283629', 'audio/mpeg');
            //$item->addTag('author', 'thisisnot@myemail.com (Antonio Ramirez)');
            $item->addTag('guid', Yii::app()->createAbsoluteUrl('/'),array('isPermaLink'=>'true'));
            $feed->addItem($item);
        }


        $feed->generateFeed();
        Yii::app()->end();
    }


}