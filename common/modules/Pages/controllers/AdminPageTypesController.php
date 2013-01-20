<?php

class AdminPageTypesController extends AdminController
{
	public function actionIndex()
	{
        $model = new PageTypes();
        $this->render('index',array('model'=>$model));
	}


    public function actionCreate()
    {
        $model=new PageTypes;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['PageTypes']))
        {

            $model->attributes=$_POST['PageTypes'];
            if($model->save())
                $this->redirect(array('index','id'=>$model->id));
        }


        $this->render('create',array(
            'model'=>$model,
        ));
    }




    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['PageTypes']))
        {
            $model->attributes=$_POST['PageTypes'];
            if($model->save())
                $this->redirect(array('index','id'=>$model->id));
        }

        $this->render('update',array(
            'model'=>$model,
        ));
    }




    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }




    public function loadModel($id)
    {
        $model=PageTypes::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='pages-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}