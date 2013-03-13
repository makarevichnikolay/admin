<?php

class UsersController extends FrontendController
{

    public function actionLogin()
    {
        $model = new Users();
        $model->scenario = 'login';
        $result['success'] = false;
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->authenticate()) {
                $result['success'] = true;
            } else {
                $result['error']= 'Неправильний логін або пароль';
            }
        }
        $result['error']= 'Неправельний логін або пароль';
        header('Content-type: application/json');
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionRegister(){
        $this->title = "Реєстрація";
        $this->pageTitle = "Реєстрація";
        $model=new Users;
        $model->scenario='register';

        $this->performAjaxValidation($model);

        if(isset($_POST['Users']))
        {
            $model->Attributes = $_POST['Users'];
            $model->role_id=1;
            $model->save();
            $model->authenticate();
            $this->redirect(Yii::app()->createUrl('Default/index'));
        }

        $this->render('register',array(
            'model'=>$model,
        ));
    }

    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createUrl('Default/index'));
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
