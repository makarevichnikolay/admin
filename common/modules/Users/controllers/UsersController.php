<?php

class UsersController extends FrontendController
{

    public function actionLogin(){
        $model = new Users();
        $model->scenario='login';
        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->validate() && $model->authenticate()){

            }else{
                $model->addError('password_repeat','Неверный логин или пароль');
                $result = array();
                foreach($model->getErrors() as $attribute=>$errors)
                    $result[CHtml::activeId($model,$attribute)]=$errors;
                echo CJSON::encode($result);
            }
        }
        Yii::app()->end();
    }

    public function actionRegister(){

    }

    public function actionLogout(){
        Yii::app()->user->logout();
        $this->redirect(array('/'));
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
