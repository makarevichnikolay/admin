<?php

class AdminBannersController extends AdminController
{

    public function actions()
    {
        return array(
            'imageUploadRedacotr'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageUpload',
                'uploadPath'=>Yii::app()->params['dataPath'].'BannersImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'BannersImages/',
                'uploadCreate'=>true,
                'permissions'=>0777,
            ),
            'imageListRedactor'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageList',
                'uploadPath'=>Yii::app()->params['dataPath'].'BannersImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'BannersImages/',
            ),
            // прочие действия
        );
    }

    public function actionCreate()
    {
        $model=new Banners;

        $this->performAjaxValidation($model);
        if(isset($_POST['Banners']))
        {
            $model->Attributes = $_POST['Banners'];
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

        if(isset($_POST['Banners']))
        {
            $model->attributes=$_POST['Banners'];
            if($model->save())
                $this->redirect(array('index'));
        }
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
        $model = new Banners('search');
        if(isset($_GET['Banners'])){
            $model->attributes = $_GET['Banners'];
        }
        $this->render('index',array('model'=>$model));
    }




    public function loadModel($id)
    {
        $model=Banners::model()->findByPk($id);
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
