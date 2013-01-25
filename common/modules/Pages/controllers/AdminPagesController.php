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
         $this->performAjaxValidation($model);

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
         $this->performAjaxValidation($model);

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


    public function actionGetImagesJSON($page_id){
       $images = PagesImages::model()->findAll('page_id = :page_id',array(':page_id'=>$page_id));
       $data = array();
        foreach($images as $val){
            $data[] = array('id'=>$val->id,'src'=>PagesImages::getImageSrc($page_id,$val->id,$val->file_name),'title'=>$val->title);
        }
        $data['curCount'] = count($images);
        $data['maxCount'] =  Yii::app()->params['Pages']['images']['maxCount'];
        echo CJSON::encode($data);
        Yii::app()->end();
    }

    public function actionImageDelete(){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $image = PagesImages::model()->findByPk($_POST['id']);
            $image->delete();
        }
        Yii::app()->end();
    }

    public function actionImageUpdate(){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $image = PagesImages::model()->findByPk($_POST['id']);
            $image->title = htmlspecialchars($_POST['title']);
            $image->update('title');
        }
        Yii::app()->end();
    }



    public  function actionMainImageUpload(){
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

    public  function actionImageUpload($id){
        if(!empty($id)){
            $id = (int)$id;
            $count = PagesImages::model()->count('page_id = :page_id',array(':page_id'=>$id));
            $config = Yii::app()->params['Pages']['images'];
            if($count <  $config['maxCount']){
                Yii::import("common.ext.EAjaxUpload.qqFileUploader");
                $dataPath = Yii::app()->params['dataPath'].'pages/'.$id.'/images/';
                Yii::app()->file->createDir(0777,$dataPath );
                $uploader = new qqFileUploader($config['ext'], $config['maxSize']);
                $result = $uploader->handleUpload($dataPath);
                if (isset($result['success'])) {
                    Yii::import('common.ext.image.Image');
                    $pages_image = new PagesImages();
                    $pages_image->page_id = $id;
                    $pages_image->file_name = $result['filename'];
                    $pages_image->save();
                    $largePath = $dataPath.'/'.$pages_image->id.'/large/';
                    $thumbPath = $dataPath.'/'.$pages_image->id.'/thumb/';
                    $originPath = $dataPath.'/'.$pages_image->id.'/origin/';
                    Yii::app()->file->createDir(0777,$originPath);
                    Yii::app()->file->createDir(0777,$largePath);
                    Yii::app()->file->createDir(0777,$thumbPath);
                    $image = new Image( $dataPath.$result['filename']);
                    $image->save($originPath.$result['filename']);
                    $image = new Image( $dataPath.$result['filename']);
                    $image->resize($config['dimensions']['large']['width'], $config['dimensions']['large']['height'] , 4)
                          ->crop($config['dimensions']['large']['width'],$config['dimensions']['large']['height'])->save($largePath.$result['filename']);
                    $image = new Image( $dataPath.$result['filename']);
                    $image->resize($config['dimensions']['thumb']['width'], $config['dimensions']['thumb']['height'] , 4)
                        ->crop($config['dimensions']['thumb']['width'],$config['dimensions']['thumb']['height'])->save($thumbPath.$result['filename']);
                    Yii::app()->file->set($dataPath.$result['filename'])->delete();
                    $result['data'] = array('id'=>$pages_image->id,'src'=>PagesImages::getImageSrc($id,$pages_image->id,$result['filename']));
                    ++$count;
                }
            }
            $result['curCount'] =$count;
            $result['maxCount'] = $config['maxCount'];
            echo CJSON::encode($result);
        }
        Yii::app()->end();
    }

    public function actionMainImageDelete(){
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $pages = $this->loadModel($_POST['id']);
                $field ='image';
                $pages->$field = false;
                $pages->update(array('image'));
                if(is_dir(Yii::app()->params['dataPath'].'pages/'.$_POST['id'].'/images/'))
                    Yii::app()->file->set(Yii::app()->params['dataPath'].'pages/'.$_POST['id'].'/images/')->delete(true);
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