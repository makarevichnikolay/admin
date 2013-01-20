<?php

require(YII_PATH . '/YiiBase.php');

/**
 * @property CConfiguration $params
 * @property CFile $file
 */
class FWebApplication extends CWebApplication {

	public function configure($config) {

		parent::configure($config);

		// remove /frontend/www from the application url
		// another way is just setup it in application params
		$baseUrl 		= preg_replace(BASE_URL_REGEXP, '', $this->request->getBaseUrl());
		$frontendUrl	= preg_replace('|/[^/]+?/[^/]+?$|', '', $this->request->getBaseUrl());

		$this->request->setBaseUrl($baseUrl);
		$this->setParams(array(
			'frontendUrl' => $frontendUrl,
			'dataUrl' => $frontendUrl . '/' . $this->params['dataRelPath'],
			'tempUrl' => $frontendUrl . '/' . $this->params['tempRelPath'],
			'dataPath' => $this->params['sitePath'] . $this->params['dataRelPath'],
			'tempPath' => $this->params['sitePath'] . $this->params['tempRelPath'],
		));
		$this->assetManager->setBaseUrl($baseUrl.'/assets');

	}

}

class Yii extends YiiBase {
	/**
	 * @return FWebApplication
	 */
	public static function app() {
		return parent::app();
	}

	/**
	 * Creates a Web application instance.
	 * @param mixed $config application configuration.
	 * @return CWebApplication
	 */
	public static function createFWebApplication($config=null) {
		return self::createApplication('FWebApplication',$config);
	}
}

Yii::setPathOfAlias('site', dirname(__FILE__) . '/../');
Yii::setPathOfAlias('common', dirname(__FILE__));
Yii::setPathOfAlias('admin',  dirname(__FILE__) . '/../' . '/admin/');
Yii::setPathOfAlias('frontend',  dirname(__FILE__) . '/../' . '/frontend/');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/ext/bootstrap');