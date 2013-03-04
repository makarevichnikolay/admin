<?php

class FrontendCommentsController extends FrontendController
{

    public function actionGetCommentJSON(){
        $comments = Comments::model()->with('user')->findAll(array(
            'order'=>'parent_id,date_create'
        ));
        $sort_comments = array();
        foreach($comments as $val){
            $sort_comments[] = array('nickname'=>$val->user->nickname,'date'=>$val->date_create,'content'=>$val->content);
        }
        echo CJSON::encode($sort_comments);
        Yii::app()->end();
    }


}