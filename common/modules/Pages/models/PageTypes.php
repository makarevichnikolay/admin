<?php

/**
 * This is the model class for table "page_types".
 *
 * The followings are the available columns in table 'page_types':
 * @property integer $id
 * @property string $title
 * @property string $module
 * @property string $controller
 * @property string $view
 */
class PageTypes extends CActiveRecord
{

    public  $defaulModule_id = 1;
    public  $defaultController = 'FrontendPages';
    public  $defaultAction = 'index';
    public  $defaultView = 'index';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PageTypes the static model class
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
		return 'page_types';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title, controller, view, action', 'length', 'max'=>255),
            array('module_id','numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, module_id, controller, view, action', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'module_id' => 'Module',
			'controller' => 'Controller',
			'view' => 'View',
            'action' => 'Action',
		);
	}


    public function beforeValidate(){
        if(empty($this->module_id))
            $this->module_id = $this->defaulModule_id;

        if(empty($this->controller))
            $this->controller = $this->defaultController;

        if(empty($this->action))
            $this->action = $this->defaultAction;

        if(empty($this->view))
            $this->view = $this->defaultView;

        return parent::beforeValidate();
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
		$criteria->compare('module_id',$this->module_id);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('view',$this->view,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}