<?php

class FrontendNewsController extends FrontendController
{
	public function actionIndex($page_id,$view='index')
	{
		$page = $this->loadModel($page_id);
		$this->render($view,array('page'=>$page));
	}


	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}