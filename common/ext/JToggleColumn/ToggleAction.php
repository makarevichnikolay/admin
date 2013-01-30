<?php

class ToggleAction extends CAction {

	public function run() {
		$attribute 		= Yii::app()->request->getParam('attribute');
		$id 			= Yii::app()->request->getParam('id');

		$controller		= Yii::app()->controller;
		//$controllerName	= Yii::app()->controller->id . "Controller";
        $toggleableAttributes = array('allow_comments','visible');
		if (in_array($attribute, $toggleableAttributes)) {

			$model = $controller->loadModel($id);
			$model->$attribute = ($model->$attribute == 0 ? 1 : 0);
			$model->save();

			if (!isset($_GET['ajax'])) {
				$controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
		} else {
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
		}
	}

}