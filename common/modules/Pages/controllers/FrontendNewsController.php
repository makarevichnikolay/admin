<?php

class FrontendNewsController extends FrontendController
{

    public function filters()
    {
        return array(
            array(
                'COutputCache + view,index',
                'duration'=>Yii::app()->params['Pages']['cacheTime'],
                'varyByParam'=>array('id','category_id'),
            ),
        );
    }

	public function actionIndex($category_id)
	{
		$model = new Pages('search');
        $model->visible=1;
        if($category_id !='all'){
            $model->category_id =  $category_id;
            $category_data = Categories::model()->with(array('parent'=>array('together'=>true)))->findByPk($category_id);
            $category = array(
                'title'=>$category_data->title,
                'id'=>$category_data->id,
                'parent_id'=>$category_data->parent_id,
                'parent_title'=>(isset($category_data->parent))?$category_data->parent->title:false,
            );
        }else{
            $category = array('title'=>'Всі');
        }
        if(isset($_GET['ajax']))
            $this->renderPartial('index',array('model'=>$model,'category'=>$category));
        else
		$this->render('index',array('model'=>$model,'category'=>$category));
	}

    public function actionView($id){
        $model= Pages::model()->with(array('category'))->findByPk($id);
        if(!$model->visible)
            throw new CHttpException(404,'The requested page does not exist.');
        $category_children = $category_parent ='';
        foreach($model->category as $val){
             if($val->category_name->parent_id == 0){
                 $category_parent .=  $val->category_name->title.' ';
             }else{
                 $category_children .= $val->category_name->title.' ';
             }
        }
        $category = array(
            'parent'=> $category_parent,
            'children'=>$category_children,

        );
        $this->render('view',array('model'=>$model,'category'=>$category));
    }


	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}