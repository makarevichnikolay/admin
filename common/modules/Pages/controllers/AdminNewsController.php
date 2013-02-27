<?php

class AdminNewsController extends AdminController
{

    public function actions()
    {
        return array(
            'toggle'=>array(
                'class'=>'common.ext.JToggleColumn.ToggleAction',
            ),
            'imageUploadRedacotr'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageUpload',
                'uploadPath'=>Yii::app()->params['dataPath'].'NewsImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'NewsImages/',
                'uploadCreate'=>true,
                'permissions'=>0777,
            ),
            'imageListRedactor'=>array(
                'class'=>'common.ext.redactorjs.actions.ImageList',
                'uploadPath'=>Yii::app()->params['dataPath'].'NewsImages/',
                'uploadUrl'=>Yii::app()->params['dataUrl'].'NewsImages/',
            ),
            // прочие действия
        );
    }



    public function actionIndex()
    {
        $model = new Pages('search');
        if(isset($_GET['Pages'])){
            $model->attributes = $_GET['Pages'];
        }
        $this->render('index',array('model'=>$model));
    }



    public function actionCreate()
    {
        $model=new Pages;
        $this->performAjaxValidation($model);
        if(isset($_POST['Pages']))
        {
            $model->attributes=$_POST['Pages'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('News/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('News/index'));
                }
            }
        }
        $pageCategories = PagesCategories::model()->findAll(array(
            'condition'=>'page_id = :page_id',
            'params'=>array(':page_id'=>$model->id),
        ));
        $model->categories = $pageCategories;
        $params = array(
            'model'=>$model,
        );
        $this->render('create',array(
            'params'=>$params,
        ));
    }




    public function actionUpdate($id)
    {
        $model=$this->loadModel($id);
        $this->performAjaxValidation($model);
        if(isset($_POST['Pages']))
        {
            $model->attributes=$_POST['Pages'];
            if($model->save()){
                if($_POST['redirect'] == 'update'){
                    $this->redirect(Yii::app()->createUrl('News/update',array('id'=>$model->id)));
                }else{
                    $this->redirect(Yii::app()->createUrl('News/index'));
                }
            }
        }
        $pageCategories = PagesCategories::model()->findAll(array(
            'condition'=>'page_id = :page_id',
            'params'=>array(':page_id'=>$model->id),
        ));
        $model->categories = CHtml::listData($pageCategories,'category_id','category_id');

        $params = array(
            'model'=>$model,
        );
        $this->render('update',array(
            'params'=>$params,
        ));
    }




    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();
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



    public  function actionMainImageUpload($field){
        Yii::import("common.ext.EAjaxUpload.qqFileUploader");

        $tempPath = Yii::app()->params['tempPath'];
        $uploader =
            new qqFileUploader(Yii::app()->params['Pages'][$field]['ext'], Yii::app()->params['Pages'][$field]['maxSize']);
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
                    $originalPath = $dataPath.'/'.$pages_image->id.'/';
                    foreach($config['dimensions'] as $key=>$value){
                        $Path = $originalPath .$key.'/';
                        Yii::app()->file->createDir(0777,$Path);
                        $image = new Image($dataPath.$pages_image->file_name);
                        $image->resize($value['width'], $value['height'] , $value['type'])
                            ->crop($value['width'],$value['height'])->save($Path.$pages_image->file_name);
                    }
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
            $field =$_POST['field'];
            $pages->$field = '';
            $pages->update(array($field));
            if(is_dir(Yii::app()->params['dataPath'].'pages/'.$_POST['id'].'/images/'.$field))
                Yii::app()->file->set(Yii::app()->params['dataPath'].'pages/'.$_POST['id'].'/images/'.$field)->delete(true);
        }

        Yii::app()->end();
    }

    public static function getCategoriesSelect($selected,$select_id='',$select_name='',$select_class=''){
        $categories = Categories::model()->with('parent')->findAll(array('order'=>'t.parent_id'));
        $data = CHtml::listData($categories,'id','title','parent.title');
        $group = array();
        foreach($categories as $val){
            if($val->parent_id == 0){
                $group[$val->id]=$val['title'];
            }else{
                break;
            }
        }
        $select= '';
        $select .= CHtml::openTag('select',array('id'=>$select_id,'name'=>$select_name,'multiple'=>"multiple",'class'=>$select_class));
                         foreach($data as $key => $value){
                             if(!is_array($value)){
                                 if(in_array($key,$selected)){
                                     $sel = true;
                                 }else{
                                     $sel = false;
                                 }
                                 $select .= CHtml::openTag('option',array('value'=>$key,'data-group'=>$group[$key],'selected'=>$sel));
                                 $select .= $value;
                                 $select .= CHtml::closeTag('option');
                                 if(isset($group[$key])){
                                     $select .= CHtml::openTag('optgroup',array('label'=> $group[$key]));
                                 if(isset($data[$group[$key]]) && is_array($data[$group[$key]])){
                                     foreach($data[$group[$key]] as $id => $text){
                                         if(in_array($id,$selected)){
                                             $sel = true;
                                         }else{
                                             $sel = false;
                                         }
                                         $select .= CHtml::openTag('option',array('value'=>$id,'selected'=>$sel));
                                         $select .= $text;
                                         $select .= CHtml::closeTag('option');
                                     }
                                 }
                                 }
                                     $select .= CHtml::closeTag('optgroup');
                             }else{
                                 break;
                             }
                         }
        $select .= CHtml::closeTag('select');

     return $select;
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}