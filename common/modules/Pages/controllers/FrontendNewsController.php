<?php

class FrontendNewsController extends FrontendController
{
	public function actionIndex($category_id)
	{
		$model = new Pages('search');
        if($category_id !='all'){
            $model->category_id =  $category_id;
            $category_data = Categories::model()->findByPk($category_id);
            $category = array('title'=>$category_data->title,'id'=>$category_data->id,'parent_id'=>$category_data->parent_id);
        }else{
            $category = array('title'=>'Всі');
        }
		$this->render('index',array('model'=>$model,'category'=>$category));
	}


	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}