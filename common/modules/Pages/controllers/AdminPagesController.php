<?php

class AdminPagesController extends AdminController
{
	public function actionIndex()
	{
      /*  for($i=1; $i<10000;$i++){
            $model = new Pages;
            $model->type_id = 1;
            $length = 10;
            $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
            shuffle($chars);
            $url= implode(array_slice($chars, 0, $length));
            $model->url = $url;
            $length = 100;
            $chars = array_merge(range(0,9), range('a','z'), range('A','Z'));
            shuffle($chars);
            $content= implode(array_slice($chars, 0, $length));
            $model->content = $content;
            $model->save(true);
        }*/

		$model = new Pages;
		$this->render('index',array('model'=>$model));
	}



    public function actionCreate()
    {
        $model=new Pages;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Pages']))
        {
            $model->attributes=$_POST['Pages'];
            if($model->save())
                $this->redirect(array('index','id'=>$model->id));
        }

        $pageTypes = PageTypes::model()->findAll(array(
            'select'=>'id,title'
        ));


        $this->render('create',array(
            'model'=>$model,
            'pageTypes'=>$pageTypes,
        ));
    }




    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Pages']))
        {
            $model->attributes=$_POST['Pages'];
            if($model->save())
                $this->redirect(array('index','id'=>$model->id));
        }

        $pageTypes = PageTypes::model()->findAll(array(
            'select'=>'id,title'
        ));

        $this->render('update',array(
            'model'=>$model,
            'pageTypes'=>$pageTypes,
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
        $model=Pages::model()->findByPk($id);
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

}