<?php

class PagesModule extends CWebModule implements IURLRule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'Pages.models.*',
			'Pages.components.*',

		));
	}

    public function parseUrlF($manager,$request,$pathInfo,$rawPathInfo){
        $page = Pages::model()->find(array(
                                            'condition'=>'url=:url',
                                            'params'=>array(':url'=>$pathInfo),
                                            'select'=>'id'
                                           ));
        if($page){
            $_GET['page_id'] = $page->id;
           // $page->type->module . '/' . $page->type->controller . '/' . $page->type->action
            return 'Pages/FrontendNews/index';
        }
        return false;
    }

    public function createUrlF($manager,$route,$params,$ampersand){
        if($route == 'Pages/FrontendPages/index'){
            $page = Pages::model()->findByPk($params['id'],array('select'=>'url'));
            if($page){
                return $page->url;
            }
        }
        return false;
    }

    public function createAbsoluteUrlF($route,$params){
        return Yii::app()->params["frontendUrl"] . '/' . $this->createUrlF(null,$route,$params,null);
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
