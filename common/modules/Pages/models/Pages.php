<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $content
 * @property integer $publish
 */
class Pages extends CActiveRecord
{

    public $categories;
    public $category_id;
    public  $defaultPageTypeId = 1;
    public $date_from;
    public $date_to;
    public $orderby = 'date DESC';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Page the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url,title', 'required'),
            array('url','unique','message'=>'{attribute}:{value} already exists!'),
            array('title, keywords_meta, video,description_meta,title_meta, url, author_name, author_image, author_description, content, main_image', 'type', 'type'=>'string'),
            array('title, keywords_meta, video,description_meta,title_meta, url, author_name, author_image, main_image, date_update, date_create', 'length', 'max'=>'255','encoding'=>'utf8'),
            array('visible, visible_on_main, allow_comments,hidden_in_main_list,video_new,photo_new', 'boolean'),
            array('type_id, user_id','numerical' ,'integerOnly'=>true),
			array('categories', 'safe'),
            array('date, date_create, date_update', 'date','format'=>'yyyy-mm-dd hh:mm:ss'),
            array('date_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),
            array('date_create,date_update','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),
			array('id,type_id, url, title, author_name, content, visible, visible_on_main, allow_comments, date_from, date_to, categories,page_id,hidden_in_main_list,video_new,photo_new,orderby', 'safe', 'on'=>'search,frontendSearch'),

		);
	}



	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'type_id'=>'Тип страницы',
            'title' => 'Заголовок',
            'keywords_meta' => 'Ключевые слова(Meta)',
            'description_meta' => 'Описание(Meta)',
            'title_meta' => 'Заголовок(Meta)',
            'video'=>'Видео',
            'url' => 'Url',
            'date'=> 'Дата',
            'categories'=> 'Категории',
            'author_name'=> 'Автор',
            'author_image'=> 'Фото автора',
            'author_description'=> 'Описание автора',
            'content' => 'Контент',
            'main_image' => 'Изображение новости',
            'video_new'=> 'Видеоновость',
            'photo_new'=> 'Фотоновость',
            'visible'=> 'Отображать',
            'visible_on_main'=>'Отображать на главной',
            'hidden_in_main_list'=>'Не публиковать в общей ленте',
            'allow_comments'=> 'Разрешить коментарии',
            'user_id'=>'Пользователь',
            'date_create'=>'date_create',
            'date_update'=>'date_update'
		);
	}

    public static  function  getFreshNews($limit = 10){
        $criteria= new CDbCriteria();
        //$criteria->limit = $limit;
        $criteria->compare('hidden_in_main_list',0);
        $criteria->compare('visible',1);
        $criteria->order = 'date DESC';
        $criteria->with = array('pageInfo');
        $criteria->together = true;
        return  new CActiveDataProvider('Pages', array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>$limit
                ),
            )
        );
    }

    public static  function  getMoreRead($limit = 10){
        $criteria= new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->order = 'pageInfo.count_visited DESC';
        $criteria->compare('visible',1);
        $criteria->with = array('pageInfo');
        $criteria->together = true;
        return  new CActiveDataProvider('Pages', array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );
    }

    public static  function  getMoreComment($limit = 10){
        $criteria= new CDbCriteria();
        $criteria->limit = $limit;
        $criteria->order = 'pageInfo.count_comments DESC';
        $criteria->compare('visible',1);
        $criteria->with = array('pageInfo');
        $criteria->together = true;
        return  new CActiveDataProvider('Pages', array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );
    }

    public static function getMainNews(){
        $criteria= new CDbCriteria();
        $criteria->limit = 3;
        $criteria->compare('visible_on_main',1);
        $criteria->compare('visible',1);
        $criteria->addCondition('main_image != ""');
        $criteria->order = 'date DESC';
        $criteria->with = array('pageInfo');
        $criteria->together = true;
        return  new CActiveDataProvider('Pages', array(
                'criteria'=>$criteria,
                'pagination'=>false
            )
        );
   }

    private function tempToData($name){
        $tempPath = Yii::app()->params['tempPath'];
        if( file_exists($tempPath.$this->$name)){
            $dataPath =  Yii::app()->params['dataPath'];
            $originalPath =$dataPath.'pages/'.$this->id.'/images/'. $name .'/';
            if(!is_dir($originalPath)){
                Yii::app()->file->createDir(0777,$originalPath);
            }else{
                Yii::app()->file->set($originalPath)->delete(true);
                Yii::app()->file->createDir(0777,$originalPath);
            }
            Yii::import('common.ext.image.Image');
            Yii::app()->file->set($tempPath.$this->$name)->move($originalPath.$this->$name);
            $config = Yii::app()->params['Pages'][$name];
            $watermarkFile = $dataPath.'watermark.png';
            foreach($config['dimensions'] as $key=>$value){
                $Path = $originalPath .$key.'/';
                Yii::app()->file->createDir(0777,$Path);
                $image = new Image($originalPath.$this->$name);
                $type = 3;
                $width = $image->width;
                $height = $image->height;
                if ($image->width > $image->height ){
                    $type = 3;
                    $height = $value['height'];
                }else{
                    $type = 4;
                    $width = $value['width'];
                }
                $image->resize($width, $height , $type);
                if($value['crop'])
                   $image->crop($value['width'],$value['height']);
                $image->save($Path.$this->$name);
                if($value['watermark']){
                    $image = new Image($Path.$this->$name);
                    $image->watermark($watermarkFile);
                    $image->save($Path.$this->$name);
                }

            }
        }
    }

    public function afterSave(){
        if(!empty($this->main_image)){
            $this->tempToData('main_image');
        }

        if(!empty($this->author_image)){
            $this->tempToData('author_image');
        }

       if(is_array($this->categories) && !empty($this->categories)){
           PagesCategories::model()->deleteAll('page_id=:page_id',array(':page_id'=>$this->id));
           foreach($this->categories as $category_id){
             $category = PagesCategories::model()->find(array(
                                             'condition'=>'page_id = :page_id AND category_id = :category_id',
                                             'params'=>array(':page_id'=>$this->id,':category_id'=>$category_id)
              ));
              if(!$category){
                  $pageCategory = new PagesCategories();
                  $pageCategory->page_id = $this->id;
                  $pageCategory->category_id = $category_id;
                  $pageCategory->save();
              }
           }
       }
       return parent::afterSave();
    }



    protected function beforeDelete()
    {
        PagesCategories::model()->deleteAll(
            'page_id = :page_id',
            array(':page_id' => $this->id)
        );
        PageInfo::model()->deleteAll('page_id = :page_id', array(':page_id' => $this->id));
        PagesImages::model()->deleteAll('page_id = :page_id', array(':page_id' => $this->id));
        $originalPath = Yii::app()->params['dataPath'].'pages/'.$this->id.'/';

        if(is_dir($originalPath)){
            Yii::app()->file->set($originalPath)->delete(true);
        }

        return parent::beforeDelete();
    }


     public static function getImageSrc($field,$size,$id,$file_name){
         return Yii::app()->params['dataUrl'] . 'pages/' . $id . '/images/' . $field . '/' . $size . '/' . $file_name;
     }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'type'    => array(self::BELONGS_TO, 'pageTypes',    'type_id'),
            'category'    => array(self::HAS_MANY, 'PagesCategories','page_id','with'=>array('category_name')),
            'category_search'    => array(self::HAS_MANY, 'PagesCategories','page_id'),
            'category_one'    => array(self::HAS_ONE, 'PagesCategories','page_id','with'=>array('category_name')),
            'pageInfo'    => array(self::HAS_ONE, 'PageInfo',    'page_id'),
        );
    }

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        //  $criteria->with = array('category'=>array('joinType'=>'INNER JOIN'));
        if(is_array($this->categories) && !empty($this->categories)){
            $criteria->with = array('category_search');
            $criteria->addInCondition('category_search.category_id',$this->categories,"OR");
            $criteria->together = true;
            $criteria->group = 'category_search.page_id';
        }
        if($this->category_id && !empty($this->category_id)){
            $criteria->with = array('category_search');
            $criteria->compare('category_search.category_id',$this->category_id);
            $criteria->together = true;
            $criteria->group = 'category_search.page_id';
        }


		$criteria->compare('id',$this->id);
        $criteria->compare('type_id',$this->type_id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
        $criteria->compare('author_name',$this->author_name,TRUE);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('visible',$this->visible);
        $criteria->compare('hidden_in_main_list',$this->hidden_in_main_list);
        $criteria->compare('video_new',$this->video_new);
        $criteria->compare('photo_new',$this->photo_new);
        $criteria->compare('visible_on_main',$this->visible_on_main);
        $criteria->compare('allow_comments',$this->allow_comments);


        if((isset($this->date_from) && trim($this->date_from) != "") && (isset($this->date_to) && trim($this->date_to) != ""))
            $criteria->addBetweenCondition('date', ''.$this->date_from.'', ''.$this->date_to.'');


        return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>10
            ),
            'sort'=>array(
                'defaultOrder'=>'date DESC',
            ),

        ));
	}

    public static  function getByCategory($id,$limit = 3){
        $criteria=new CDbCriteria;
        $criteria->with = array();
        $criteria->together = true;
        $criteria->with[] = 'category_search';
        $criteria->compare('category_search.category_id',$id);
        $criteria->group = 'category_search.page_id';
        $criteria->compare('visible',1);
        $criteria->limit = $limit;

        return new CActiveDataProvider('Pages', array(
            'criteria'=>$criteria,
            'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'date DESC',
            ),

        ));
    }


    public function underCategorySearch(){
        $criteria = new CDbCriteria();
        $criteria->compare('parent_id',$this->category_id);
        return new CActiveDataProvider('Categories', array(
            'criteria'=>$criteria,
            'pagination'=>false
        ));
    }

    public function frontendSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array('pageInfo','category_one');
        $criteria->together = true;
        if($this->category_id && !empty($this->category_id)){
            $criteria->with[] = 'category_search';
            $criteria->compare('category_search.category_id',$this->category_id);
            $criteria->group = 'category_search.page_id';
        }
        $criteria->compare('visible',1);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>10
            ),
            'sort'=>array(
                'defaultOrder'=>$this->orderby,
            ),

        ));
    }

    public function frontendDoseSearch()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;
        $criteria->with = array('pageInfo','category_one');
        $criteria->together = true;
        if($this->category_id && !empty($this->category_id)){
            $criteria->with[] = 'category_search';
            $criteria->compare('category_search.category_id',$this->category_id);
            $criteria->group = 'category_search.page_id';
        }
        $criteria->compare('visible',1);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>27
            ),
            'sort'=>array(
                'defaultOrder'=>$this->orderby,
            ),

        ));
    }

}