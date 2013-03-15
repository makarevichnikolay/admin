<?php

class AdminCommentsController extends AdminController
{
	public function actionIndex($page_id=null,$user_id=null)
	{
        $model = new Comments('search');
        if(isset($_GET['Comments'])){
            $model->attributes = $_GET['Comments'];
        }
       if(!empty($user_id))
            $model->user_id = $user_id;
       if(!empty($page_id))
		   $model->page_id = $page_id;

        $this->render('index',array('model'=>$model));
	}

    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function loadModel($id)
    {
        $model=Comments::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}