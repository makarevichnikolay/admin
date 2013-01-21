<?php

class AdminMenuController extends Controller
{
    public $menu;

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionCreate(){
        $model = new MenuItems();
        $url = $this->createUrl('/Menu/AdminMenu/Create');
        $this->performAjaxValidation($model);

            if(Yii::app()->getRequest()->getIsAjaxRequest()){
                if(isset($_POST['MenuItems'])){
                    $model->attributes=$_POST['MenuItems'];
                    if($model->validate()){
                        $model->save();
                        echo CJSON::encode(array('result'=>'save'));
                    }else{
                        echo CJSON::encode(array('result'=>$this->renderPartial('_form',array('model'=>$model,'url'=>$url),true,true)));
                    }
                }else{
                    $this->renderPartial('_form',array('model'=>$model,'url'=>$url),false,true);
                }
                Yii::app()->end();
            }
    }

    public function actionUpdate($id){
        $model=$this->loadModel($id);
        $url = $this->createUrl('/Menu/AdminMenu/Update',array('id'=>$id));
        $this->performAjaxValidation($model);

        if(Yii::app()->getRequest()->getIsAjaxRequest()){
            if(isset($_POST['MenuItems'])){
                $model->attributes=$_POST['MenuItems'];
                if($model->validate()){
                    $model->save();
                    echo CJSON::encode(array('result'=>'save'));
                }else{
                    echo CJSON::encode(array('result'=>$this->renderPartial('_form',array('model'=>$model,'url'=>$url),true,true)));
                }
            }else{
                $this->renderPartial('_form',array('model'=>$model,'url'=>$url),false,true);
            }
            Yii::app()->end();
        }
    }


    public function actionGetMenuJSON(){
        $menu = MenuItems::model()->findAll(array(
            'order'=>'parent_id,position'
        ));
        $sort_menu =array();
        $sort_menu['dd_item'] = array();
        $sort_menu['dd_item'] = $this->getChildrenRecursiveJSON($menu,0);
        echo CJSON::encode($sort_menu);
        Yii::app()->end();
    }

    public function actionSortSave(){
        $data = CJSON::decode($_POST['data']);
        $this->updateMenuRecursive(0,$data);
        Yii::app()->end();
    }

    public function getChildrenRecursiveJSON($data,$id){
         $child = array();
         foreach($data as $val){
             if($val->parent_id == $id){
                 if($children = $this->getChildrenRecursiveJSON($data,$val->id)){
                     $child [] = array('id'=>$val->id,'label'=>$val->title, 'url'=>Yii::app()->createUrl($val->url),'children'=>$children);
                 }else{
                     $child [] = array('id'=>$val->id,'label'=>$val->title,'url'=>Yii::app()->createUrl($val->url),);
                 }
             }
         }
        if(!empty($child )){
            return $child;
        }
        return false;
    }

    public function updateMenuRecursive($parent_id,$data){
        foreach($data as $key=>$value){
            if(isset($value['children'])){
                $this->updateMenuRecursive($value['id'],$value['children']);
            }
            MenuItems::model()->updateByPk($value['id'],array('position'=>$key,'parent_id'=>$parent_id));
        }
    }

    public function loadModel($id)
    {
        $model=MenuItems::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='Menu-Form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}