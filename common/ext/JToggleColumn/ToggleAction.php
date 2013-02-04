<?php

class ToggleAction extends CAction {

	public function run() {
		$attribute 		= Yii::app()->request->getParam('attribute');
		$id 			= Yii::app()->request->getParam('id');

		$controller		= Yii::app()->controller;

			$model = $controller->loadModel($id);
			$model->$attribute = ($model->$attribute == 0 ? 1 : 0);
			$model->save();

			if (!isset($_GET['ajax'])) {
				$controller->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			}
      Yii::app()->end();
	}

}