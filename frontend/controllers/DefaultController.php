<?php

class DefaultController extends FrontendController
{


    public function actionIndex()
    {
        $this->pageTitle="Кіровоградський медіапортал \"Акула\"";
        $this->render('index', array());
    }


    public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}