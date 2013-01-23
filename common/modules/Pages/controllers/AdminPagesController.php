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
            if($model->save()){
                if(isset($_POST['image_name_temp']) && !empty($_POST['image_name_temp'])){
                    $tempPath = Yii::app()->params['tempPath'];
                    if( file_exists($tempPath.$_POST['image_name_temp'])){
                        $model->image = true;
                        $image_name = Yii::app()->params['Pages']['mainImage']['name'];
                        $model->update(array('image'));
                        $savePath = Yii::app()->params['dataPath'].'pages/'.$model->id.'/images/main';
                        if(!is_dir($savePath)){
                            Yii::app()->file->createDir(0777,$savePath);
                        }else{
                            Yii::app()->file->set($savePath)->delete(true);
                            Yii::app()->file->createDir(0777,$savePath);
                        }
                        Yii::app()->file->set($tempPath.$_POST['image_name_temp'])->move($savePath.'/'.$image_name);
                        //$image = new Image($savePath.'/'.$image_name);
                        //$image->resize(300, 300)->save($savePath.'/'.$model->image_main );
                    }
                }
                $this->redirect(array('index','id'=>$model->id));
            }

        }

        $Categories = CHtml::listData(Categories::model()->findAll(),'id','title');
        $pageCategories = PagesCategories::model()->findAll(array(
            'condition'=>'page_id = :page_id',
            'params'=>array(':page_id'=>$model->id),
        ));
        $model->categories = $pageCategories;

        $this->render('create',array(
            'model'=>$model,
            'Categories'=>$Categories,
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
            if($model->save()){
                if(isset($_POST['image_name_temp']) && !empty($_POST['image_name_temp'])){
                    $tempPath = Yii::app()->params['tempPath'];
                    if( file_exists($tempPath.$_POST['image_name_temp'])){
                        $model->image = true;
                        $image_name = Yii::app()->params['Pages']['mainImage']['name'];
                        $model->update(array('image'));
                        $savePath = Yii::app()->params['dataPath'].'pages/'.$model->id.'/images/main';
                        if(!is_dir($savePath)){
                            Yii::app()->file->createDir(0777,$savePath);
                        }else{
                            Yii::app()->file->set($savePath)->delete(true);
                            Yii::app()->file->createDir(0777,$savePath);
                        }
                        Yii::app()->file->set($tempPath.$_POST['image_name_temp'])->move($savePath.'/'.$image_name);
                        //$image = new Image($savePath.'/'.$image_name);
                        //$image->resize(300, 300)->save($savePath.'/'.$model->image_main );
                    }
                }
                $this->redirect(array('index','id'=>$model->id));
            }
        }

        $Categories = CHtml::listData(Categories::model()->findAll(),'id','title');
        $pageCategories = PagesCategories::model()->findAll(array(
            'condition'=>'page_id = :page_id',
            'params'=>array(':page_id'=>$model->id),
        ));
        $model->categories = CHtml::listData($pageCategories,'category_id','category_id');

        $this->render('update',array(
            'model'=>$model,
            'Categories'=>$Categories,
        ));
    }




    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }


    public  function actionImageUpload(){
        Yii::import("common.ext.EAjaxUpload.qqFileUploader");

        $tempPath = Yii::app()->params['tempPath'];
        $uploader =
            new qqFileUploader(Yii::app()->params['Pages']['mainImage']['ext'], Yii::app()->params['Pages']['mainImage']['maxSize']);

        $result = $uploader->handleUpload($tempPath,true);

        if (isset($result['success'])) {
        }
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionDeleteImage(){
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $pages = $this->loadModel($_POST['id']);
                $field ='image';
                $pages->$field = false;
                $pages->update(array('image'));
                if(is_dir(Yii::app()->params['dataPath'].'news/'.$_POST['id'].'/images/'))
                    Yii::app()->file->set(Yii::app()->params['dataPath'].'news/'.$_POST['id'].'/images/')->delete(true);
            }

        Yii::app()->end();
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