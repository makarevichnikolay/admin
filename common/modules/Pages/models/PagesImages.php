<?php

/**
 * This is the model class for table "pages_images".
 *
 * The followings are the available columns in table 'pages_images':
 * @property integer $id
 * @property string $page_id
 * @property string $title
 * @property string $file_name
 */
class PagesImages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagesImages the static model class
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
		return 'pages_images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('page_id, file_name', 'required'),
			array('page_id', 'length', 'max'=>10),
			array('title, file_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, page_id, title, file_name', 'safe', 'on'=>'search'),
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
			'page_id' => 'Page',
			'title' => 'Title',
			'file_name' => 'File Name',
		);
	}

    protected function beforeDelete(){
        $path = Yii::app()->params['dataPath'].'pages/'.$this->page_id.'/images/'.$this->id.'/';
        if(is_dir($path))
            Yii::app()->file->set($path)->delete(true);
        return parent::beforeDelete();
    }
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */

    public static function getImageSrc($page_id,$id,$filename,$size='thumb'){
        $path = Yii::app()->params['dataUrl'].'pages/'.$page_id.'/'.'images/gallery/'.$id.'/';
        $path .= $size .'/'.$filename;
        return $path;
    }

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('page_id',$this->page_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('file_name',$this->file_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}