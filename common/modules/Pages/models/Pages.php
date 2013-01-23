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

    public $image_name_temp;
    public $categories;
    public  $defaultPageTypeId = 1;
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
            array('visible, image, allow_comments, type_id', 'numerical', 'integerOnly'=>true),
			array('url, title, keywords, description', 'length', 'max'=>255),
			array('content,categories', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, title, content, visible', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'type'    => array(self::BELONGS_TO, 'pageTypes',    'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'title' => 'Title',
            'type_id'=>'Type',
			'content' => 'Content',
			'visible' => 'visible',
            'categories' => 'categories'
		);
	}

    public function afterSave(){
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

    protected function beforeDelete(){
           PagesCategories::model()->deleteAll(
                                               'page_id = :page_id',
                                               array(':page_id'=>$this->id)
                                            ) ;

       return parent::beforeDelete();
    }



	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
        $criteria->with = array('type');
        $criteria->together = true;
		$criteria->compare('id',$this->id);
        $criteria->compare('type.title',$this->title,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('visible',$this->visible);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}