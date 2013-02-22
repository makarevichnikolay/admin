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
        $url = explode('/',$pathInfo);
        if($url[0] == 'all'){
            $_GET['category_id'] = 'all';
            return 'Pages/FrontendNews/index';
        }else{
            $categorie = Categories::model()->find(array(
                'condition'=>'url=:url',
                'params'=>array(':url'=>isset($url[1])?$url[1]:$url[0])
            ));
        }
        if($categorie){
            $_GET['category_id'] = $categorie->id;
            return 'Pages/FrontendNews/index';
        }
        $page = Pages::model()->find(array(
                                            'condition'=>'url=:url',
                                            'params'=>array(':url'=>$url[0]),
                                            'select'=>'id'
                                           ));
        if($page){
            $_GET['page_id'] = $page->id;
           // $page->type->module . '/' . $page->type->controller . '/' . $page->type->action
            return 'Pages/FrontendNews/view';
        }
        return false;
    }

    public function createUrlF($manager,$route,$params,$ampersand){
        if($route == 'Pages/FrontendPages/index'){
            if($params['id'] == 'all'){
                return 'all';
            }
            $categories = Categories::model()->findByPk($params['id'],array('select'=>'url'));
            if($categories){
                return $categories->url;
            }
        }
        if($route == 'Pages/FrontendPages/view'){
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
