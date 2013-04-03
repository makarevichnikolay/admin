<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $user_id
 * @property string $page_id
 * @property string $content
 * @property string $date_create
 */
class Comments extends CActiveRecord
{
    public $date_from;
    public $date_to;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, page_id, content', 'required'),
			array('user_id, page_id, parent_id', 'length', 'max'=>10),
            array('date_create','default',
                'value'=>date('Y-m-d H:i:s'),
                'setOnEmpty'=>false,'on'=>'insert'),
			array('id, user_id, page_id, content, date_create,parent_id, date_from, date_to', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO,'Users','user_id'),
            'page'=>array(self::BELONGS_TO,'Pages','page_id','select'=>'id,title'),
		);
	}

    protected  function beforeDelete(){
        Yii::app()->getModule('Pages');
        $pageInfo = PageInfo::model()->findByAttributes(array('page_id'=>$this->page_id));
        if($pageInfo){
            $pageInfo->count_comments =  $pageInfo->count_comments - 1;
            $pageInfo->update(array('count_comments'));
        }
        return parent::beforeDelete();
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'Пользователь',
			'page_id' => 'Новость',
			'content' => 'Комментарии',
			'date_create' => 'Дата',
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
        $criteria->with = array('user','page');
        $criteria->together = false;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.user_id',$this->user_id);
		$criteria->compare('t.page_id',$this->page_id);
		$criteria->compare('t.content',$this->content,true);
		$criteria->compare('t.date_create',$this->date_create);
        if((isset($this->date_from) && trim($this->date_from) != "") && (isset($this->date_to) && trim($this->date_to) != ""))
            $criteria->addBetweenCondition('t.date_create', ''.$this->date_from.'', ''.$this->date_to.'');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}