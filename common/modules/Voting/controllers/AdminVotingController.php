<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 11.03.13
 * Time: 16:44
 * To change this template use File | Settings | File Templates.
 */

class AdminVotingController extends AdminController
{
    public function actionIndex()
    {
        $model = new Voting('search');
        if(isset($_GET['Voting'])){
            $model->attributes = $_GET['Voting'];
        }
        $this->render('index',array('model'=>$model));
    }



    public function actionCreate()
    {
        $model=new Voting;
        $this->performAjaxValidation($model);
        if(isset($_POST['Voting']))
        {
            $model->attributes=$_POST['Voting'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVoting/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVoting/index'));
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
        if(isset($_POST['Voting']))
        {
            $model->attributes=$_POST['Voting'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVoting/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('Voting/AdminVoting/index'));
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




    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model=Voting::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='voting-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}