<?php

class StaticPagesModule extends CWebModule implements IURLRule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'StaticPages.models.*',
			'StaticPages.components.*',
		));
	}

    public function parseUrlF($manager,$request,$pathInfo,$rawPathInfo){
        $url = explode('/',$pathInfo);
        $page = StaticPages::model()->find(array(
            'condition'=>'url=:url',
            'params'=>array(':url'=>$url[0]),
            'select'=>'id'
        ));
        if($page){
            $_GET['id'] = $page->id;
            return 'StaticPages/FrontendStaticPages/view';
        }
        return false;
    }

    public function createUrlF($manager,$route,$params,$ampersand){
        if($route == 'StaticPages/FrontendStaticPages/view'){
            if(isset($params['url'])){
                return $params['url'];
            }else{
                $page = StaticPages::model()->findByPk($params['id'],array('select'=>'url'));
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
