<?php

class AdminUsersController extends AdminController
{

    public function actions()
    {
        return array(
            'toggle'=>array(
                'class'=>'common.ext.JToggleColumn.ToggleAction',
            ),
            // прочие действия
        );
    }

    public function actionLogin(){
        $model = new Users();
        $model->scenario='login';
        $this->performAjaxValidation($model);
        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->validate() && $model->authenticate()){
                $this->redirect(Yii::app()->user->returnUrl);
            }else{
                $model->addError('password_repeat','Неверный логин или пароль');
            }

        }
        $this->pageTitle = 'Авторизация';
        $this->layout='//layouts/clear';
        $this->render('_login',array('model'=>$model));
    }



    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(array('/Users/AdminUsers/Login'));
    }



    public function actionCreate()
    {
        $model=new Users;
        $model->scenario='register';

        $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {
            $model->Attributes = $_POST['Users'];
            if($model->save())
                $this->redirect(array('index'));
        }

        $this->render('create',array(
            'model'=>$model,
        ));
    }


    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {
            if(empty($_POST['Users']['password'])){
              unset($_POST['Users']['password']);
              unset($_POST['Users']['password_repeat']);
            }else{
                $model->scenario='register';
            }
            $model->attributes=$_POST['Users'];
            if($model->save())
                $this->redirect(array('index'));
        }
        $model->password = false;
        $model->password_repeat = false;
        $this->render('update',array(
            'model'=>$model,
        ));
    }


    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    public function actionIndex()
    {
        $model = new Users('search');
        if(isset($_GET['Users'])){
            $model->attributes = $_GET['Users'];
        }
        $this->render('index',array('model'=>$model));
    }




    public function loadModel($id)
    {
        $model=Users::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
