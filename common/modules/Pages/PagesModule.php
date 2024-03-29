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
        if($url[0] == 'remind'){
            return 'Users/Users/remind';
        }
        $categorie = Categories::model()->find(array(
                'condition'=>'url=:url',
                'params'=>array(':url'=>isset($url[1])?$url[1]:$url[0])
        ));
        if($categorie){
             if($categorie->id == 20)
                return 'Pages/FrontendNews/feadback';
             $_GET['category_id'] = $categorie->id;
             return 'Pages/FrontendNews/index';
        }
        $page = Pages::model()->find(array(
                                            'condition'=>'url=:url',
                                            'params'=>array(':url'=>$url[0]),
                                            'select'=>'id'
                                           ));
        if($page){
            $_GET['id'] = $page->id;
            return 'Pages/FrontendNews/view';
        }
        return false;
    }

    public function createUrlF($manager,$route,$params,$ampersand){
        if($route =='Users/Users/remind'){
           return 'remind';
        }
        if($route == 'Pages/FrontendPages/index'){
            if($params['id'] == 'all'){
                return 'all';
            }
            $categories = Categories::model()->findByPk($params['id'],array('select'=>'url'));
            if($categories){
                return $categories->url;
            }
        }
        if($route == 'Pages/FrontendNews/view'){
            if(isset($params['url'])){
                return $params['url'];
            }else{
                $page = Pages::model()->findByPk($params['id'],array('select'=>'url'));
                if($page){
                    return $page->url;
                }
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
