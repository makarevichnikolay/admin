<?php

class DefaultController extends FrontendController
{


    public function actionIndex()
    {
        $criteria= new CDbCriteria();
        $criteria->limit = 3;
        $criteria->compare('visible_on_main',0);
        $criteria->addCondition('main_image != ""');
        $main_news = new CActiveDataProvider('Pages', array(
            'criteria'=>$criteria,
            'pagination'=>false
            )
        );
        $this->render('index', array(
                'main_news' => $main_news,
            )
        );
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