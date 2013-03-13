<?php

class AdminStaticPagesController extends AdminController
{

    public function actions()
    {
        return array(
            'toggle'=>array(
                'class'=>'common.ext.JToggleColumn.ToggleAction',
            ),
            'imageUploadRedactor'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageUpload',
                'uploadPath'=>Yii::app()->params['dataPath'].'StaticPagesImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'StaticPagesImages/',
                'uploadCreate'=>true,
                'permissions'=>0777,
            ),
            'imageListRedactor'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageList',
                'uploadPath'=>Yii::app()->params['dataPath'].'StaticPagesImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'StaticPagesImages/',
            ),
            // прочие действия
        );
    }



    public function actionIndex()
    {
        $model = new StaticPages('search');
        if(isset($_GET['StaticPages'])){
            $model->attributes = $_GET['StaticPages'];
        }
        $this->render('index',array('model'=>$model));
    }



    public function actionCreate()
    {
        $model=new StaticPages;
        $this->performAjaxValidation($model);
        if(isset($_POST['StaticPages']))
        {
            $model->attributes=$_POST['StaticPages'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('StaticPages/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('StaticPages/index'));
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
        if(isset($_POST['StaticPages']))
        {
            $model->attributes=$_POST['StaticPages'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('StaticPages/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('StaticPages/index'));
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
        $model=StaticPages::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='StaticPages')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}