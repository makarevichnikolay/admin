<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $id
 * @property string $title
 * @property string $keywords_meta
 * @property string $description_meta
 * @property string $title_meta
 * @property string $url
 * @property string $date
 * @property string $content
 * @property integer $visible
 */
class StaticPages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StaticPages the static model class
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
		return 'static_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,url,', 'required'),
			array('visible', 'numerical', 'integerOnly'=>true),
			array('title, keywords_meta, description_meta, title_meta, url', 'length', 'max'=>255),
            array('content', 'type', 'type'=>'string'),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, keywords_meta, description_meta, title_meta, url, date, content, visible', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Описание',
			'keywords_meta' => 'Keywords Meta',
			'description_meta' => 'Description Meta',
			'title_meta' => 'Title Meta',
			'url' => 'Url',
			'date' => 'Date',
			'content' => 'Контент',
			'visible' => 'Отображать',
		);
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('keywords_meta',$this->keywords_meta,true);
		$criteria->compare('description_meta',$this->description_meta,true);
		$criteria->compare('title_meta',$this->title_meta,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('visible',$this->visible);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}