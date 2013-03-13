<?php

class FrontendStaticPagesController extends FrontendController
{

    public function filters()
    {
        return array(
           // array(
                //'COutputCache + view,index',
                //'duration'=>Yii::app()->params['Pages']['cacheTime'],
                //'varyByParam'=>array('id','category_id'),
           // ),
        );
    }



    public function actionView($id){
        $model= StaticPages::model()->findByPk($id);
        if(!$model->visible)
            throw new CHttpException(404,'The requested page does not exist.');
        $this->pageTitle = $model->title_meta;
        Yii::app()->clientScript->registerMetaTag($model->description_meta, 'description');
        Yii::app()->clientScript->registerMetaTag($model->keywords_meta, 'keywords');
        $this->render('view',array('model'=>$model));
    }



	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}