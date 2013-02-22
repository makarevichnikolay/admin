<?php

class MenuModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'Menu.models.*',
			'Menu.components.*',
		));
	}

    public function getMenu(){
        $menu = MenuItems::model()->findAll(array(
            'order'=>'parent_id,position'
        ));
        return $this->getMenuItemsRecursive($menu,0);
    }

    public function getMenuItemsRecursive($data,$id){
        $items = array();
        foreach($data as $val){
            if($val->parent_id == $id){
                if($children = $this->getMenuItemsRecursive($data,$val->id)){
                    $items[] = array('label'=>$val->title, 'url'=>Yii::app()->createUrl($val->url),'items'=>$children);
                }else{
                    $items[] = array('label'=>$val->title,'url'=>Yii::app()->createUrl($val->url));
                }
            }
        }
        if(!empty($items)){
            return $items;
        }
        return false;
    }

    public  function getFrontendMenu($class = 'first',$limit=7,$offset=0){
        return renderMenu::getFrontendMenu($class ,$limit,$offset);
    }

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
