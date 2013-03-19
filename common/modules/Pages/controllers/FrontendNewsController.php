<?php

class FrontendNewsController extends FrontendController
{

    public function filters()
    {
        return array(
           // array(
                //'COutputCache + view,index',
                //'duration'=>Yii::app()->params['Pages']['cacheTime'],
                //'varyByParam'=>array('id','category_id'),
           // ),
        );
    }

	public function actionIndex($category_id)
	{
		$model = new Pages('frontendSearch');
        $model->visible=1;
        if($category_id !='all'){
            $model->category_id =  $category_id;
            $category_data = Categories::model()->with(array('parent'=>array('together'=>true)))->findByPk($category_id);
            $category = array(
                'title'=>$category_data->title,
                'id'=>$category_data->id,
                'parent_id'=>$category_data->parent_id,
                'parent_title'=>(isset($category_data->parent))?$category_data->parent->title:false,
            );
        }else{
            $category = array('title'=>'Всі');
        }
        $typeSearch = 'FrontendSearch';
        if($category_data->parent_id == 12 || $category_data->parent_id == 13 ||$category_data->parent_id==10){
            $model->orderby = 't.title';
        }
        if($category_id == 11 ||  $category_data->parent_id == 11 ){
            $_view = 'common.modules.Pages.views.frontendNews._afisha';
        }elseif( $category_id == 10 || $category_id == 12 || $category_id == 13){
           $_view = 'common.modules.Pages.views.frontendNews._main_dose';
            $typeSearch = "underCategorySearch";
        }elseif($category_data->parent_id == 10 || $category_data->parent_id==12 || $category_data->parent_id==13){
            $_view = 'common.modules.Pages.views.frontendNews._dose';
            $typeSearch = "frontendDoseSearch";
        }else{
            $_view = 'common.modules.Pages.views.frontendNews._new';
        }


        $this->pageTitle = $category['title'];
        Yii::app()->clientScript->registerMetaTag($category['title'], 'description');
        Yii::app()->clientScript->registerMetaTag($category['title'], 'keywords');
        if(isset($_GET['ajax']))
            $this->renderPartial('index',array('model'=>$model,'category'=>$category,'_view'=>$_view,'typeSearch'=>$typeSearch));
        else
		$this->render('index',array('model'=>$model,'category'=>$category,'_view'=>$_view,'typeSearch'=>$typeSearch));
	}

    public function actionView($id){
        $model= Pages::model()->with(array('category'))->findByPk($id);
        if(!$model->visible)
            throw new CHttpException(404,'The requested page does not exist.');
        $category_parent =$cur_category_ids = array();
        foreach($model->category as $val){
            $cur_category_ids [] = $val->category_name->parent_id;
            $cur_category_ids [] = $val->category_name->id;
             if($val->category_name->parent_id == 0){
                 $category_parent[$val->category_name->title]=Yii::app()->createUrl('Pages/FrontendNews/index',array('category_id'=>$val->category_name->id));
             }
        }
        $category = array(
            'parent'=>   $category_parent ,

        );
        $this->pageTitle = $model->title_meta;
        Yii::app()->clientScript->registerMetaTag($model->description_meta, 'description');
        Yii::app()->clientScript->registerMetaTag($model->keywords_meta, 'keywords');
        $pageInfo = PageInfo::model()->findByAttributes(array('page_id'=>$id));
        if($pageInfo){
           $pageInfo->count_visited = $pageInfo->count_visited + 1;
            $pageInfo->update(array('count_visited'));
        }else{
            $pageInfo = new PageInfo();
            $pageInfo->page_id = $id;
            $pageInfo->count_visited = 1;
            $pageInfo->save();
        }
        $this->render('view',array('model'=>$model,'category'=>$category,'pageInfo'=>$pageInfo,'cur_category_ids'=>$cur_category_ids));
    }

    public function actionFeadback(){

        $model=new Feadback;
        $emailSend = false;
        if(isset($_POST['ajax']) && $_POST['ajax']==='feadback')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        Yii::app()->getModule('StaticPages');
        $staticPage = StaticPages::model()->findByPk(4);
        if($staticPage)
           $text = $staticPage->content;
        else
           $text = '';

        if(isset($_POST['Feadback']))
        {
            $model->attributes=$_POST['Feadback'];
            if($model->validate()){
                $to= Yii::app()->params['adminEmail'];
                $from=$model->email;
                $subj="Акула - Новость от автора";
                $text=$model->about.'<br />Телефон:'.$model->phone;
                $file=CUploadedFile::getInstance($model,'file');
                $image = CUploadedFile::getInstance($model,'image');
                $files = array();
                if($file){
                    $file->saveAs(Yii::app()->params['tempPath'].$file);
                    $files[''.$file] = file_get_contents(Yii::app()->params['tempPath'].$file);
                }
                if($image){
                    $image->saveAs(Yii::app()->params['tempPath'].$image);
                    $files[''.$image] = file_get_contents(Yii::app()->params['tempPath'].$image);
                }
                if(Helper::sendMail($to, $from, $subj, $text, $files)){
                    Yii::app()->user->setFlash('success', '<strong>Відправленно!</strong>');
                    $emailSend = true;
                }else{
                    Yii::app()->user->setFlash('error', '<strong>Помилка при відправці!</strong>');
                }
            }
        }

        $this->render('feadback',array(
            'model'=>$model,
            'emailSend'=>$emailSend,
            'text'=>$text
        ));
    }

    public function actionVoting(){
        if(isset($_POST['id'])){
            Yii::app()->getModule('Voting');
            $id = $_POST['id'];
            $cookie = isset(Yii::app()->request->cookies['voting']) ? Yii::app()->request->cookies['voting'] : false;
            $criteria = new CDbCriteria();
            $criteria->compare('t.visible', 1);
            $voting = Voting::model()->find($criteria);
            if($voting && (!$cookie || $cookie->value !=  $voting->id)){
                $answer = VotingAnswers::model()->findByAttributes(array('voting_id'=>$voting->id,'question_id'=>$id));
                if($answer){
                    Yii::app()->request->cookies['voting'] = new CHttpCookie('voting', $voting->id);
                    $voting->count_vote =  $voting->count_vote +1;
                    $voting->update('count_vote');
                    $answer->count =  $answer->count +1;
                    $answer->update('count');
                }else{
                    $answer = new VotingAnswers();
                    $answer->voting_id = $voting->id;
                    $answer->question_id = $id;
                    $answer->count = 1;
                    if($answer->save()){
                        Yii::app()->request->cookies['voting'] = new CHttpCookie('voting', $voting->id);
                        $voting->count_vote =  $voting->count_vote +1;
                        $voting->update('count_vote');
                    }
                }
                $this->renderPartial('_voting');
                Yii::app()->end();
            }
        }
    }




	public function loadModel($id)
	{
		$model=Pages::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}