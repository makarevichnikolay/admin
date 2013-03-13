<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 11.03.13
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

class AdminVotingQuestionsController extends AdminController
{
    public function actionIndex($voting_id=false)
    {
        $model = new VotingQuestions('search');
        if($voting_id){
            $model->voting_id = $voting_id;
        }
        if(isset($_GET['VotingQuestions'])){
            $model->attributes = $_GET['VotingQuestions'];
        }
        $this->render('index',array('model'=>$model));
    }



    public function actionCreate()
    {
        $model=new VotingQuestions;
        $this->performAjaxValidation($model);
        if(isset($_POST['VotingQuestions']))
        {
            $model->attributes=$_POST['VotingQuestions'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVotingQuestions/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVotingQuestions/index'));
                }
            }
        }
        $params = array(
            'model'=>$model,
        );
        $this->render('create',array(
            'params'=>$params,
        ));
    }




    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);
        if(isset($_POST['VotingQuestions']))
        {
            $model->attributes=$_POST['VotingQuestions'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVotingQuestions/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVotingQuestions/index'));
                }
            }
        }
        $params = array(
            'model'=>$model,
        );
        $this->render('update',array(
            'params'=>$params,
        ));
    }


    public  function actionImageUpload($field){
        Yii::import("common.ext.EAjaxUpload.qqFileUploader");

        $tempPath = Yii::app()->params['tempPath'];
        $uploader =
            new qqFileUploader(Yii::app()->params['VotingQuestions'][$field]['ext'], Yii::app()->params['VotingQuestions'][$field]['maxSize']);
        $result = $uploader->handleUpload($tempPath,true);
        if (isset($result['success'])) {
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model=VotingQuestions::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='VotingQuestions-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}