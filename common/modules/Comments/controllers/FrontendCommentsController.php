<?php

class FrontendCommentsController extends FrontendController
{

    public function actionGetCommentJSON(){
        if(isset($_POST['page_id']) && is_numeric($_POST['page_id'])){
            if(!$_POST['id']){
                $comments = Comments::model()->with('user')->findAll(array(
                    'order'=>'parent_id,date_create'
                ));
            }else{
                $comments = Comments::model()->with('user')->findAll(array(
                    'condition'=>'t.id > :id AND page_id=:page_id',
                    'params'=>array(':id'=>(int)$_POST['id'],':page_id'=>$_POST['page_id']),
                    'order'=>'t.id'
                ));
            }
            if($comments){
                $mn = array(
                    '01'=>'Січня',
                    '02'=>'Лютого',
                    '03'=>'Березня',
                    '04'=>'Квітня',
                    '05'=>'Травня',
                    '06'=>'Червня',
                    '07'=>'Липня',
                    '08'=>'Серпня',
                    '09'=>'Вересня',
                    '10'=>'Жовтня',
                    '11'=>'Листопада',
                    '12'=>'Грудня'
                );
                $sort_comments = array();
                foreach($comments as $val){
                    $day =  (int)date('d',strtotime($val->date_create));
                    $date = $day.' '. $mn[date('m',strtotime($val->date_create))].' | '. date('H:i',strtotime($val->date_create));
                    $sort_comments[] = array('id'=>$val->id,'nickname'=>$val->user->nickname,'date'=> $date,'content'=>$val->content);
                }
            }else{
                $sort_comments = array('success'=>false);
            }
        }else{
            $sort_comments = array('success'=>false);
        }

        echo CJSON::encode($sort_comments);
        Yii::app()->end();
    }


    public function actionSaveComment(){
        $page_id = (int)$_POST['page_id'];
        $text = strip_tags($_POST['text']);
        $comment = new Comments();
        $comment->page_id =$page_id;
        $comment->content = $text;
        $comment->user_id = Yii::app()->user->id;
        if($comment->save()){
            $pageInfo = PageInfo::model()->findByAttributes(array('page_id'=>$page_id));
            if($pageInfo){
                $pageInfo->count_comments = $pageInfo->count_comments + 1;
                $pageInfo->update(array('count_comments'));
            }
          $result = array('success'=>true);
        }else{
            print_r($comment->getErrors());
            $result = array('success'=>false);
        }

        echo CJSON::encode($result);
        Yii::app()->end();
    }

}