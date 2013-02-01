<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $nickname
 * @property string $first_name
 * @property string $last_name
 * @property string $phone
 * @property string $ip
 * @property string $role_id
 * @property string $last_visited
 * @property integer $baned
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('login, password, nickname, first_name, last_name, phone, ip, role_id, last_visited, baned', 'required'),
			array('baned', 'numerical', 'integerOnly'=>true),
			array('login, password, nickname, first_name, last_name, phone, ip', 'length', 'max'=>255),
			array('role_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, login, password, nickname, first_name, last_name, phone, ip, role_id, last_visited, baned', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
            'role'=>array(self::BELONGS_TO,'UsersRole','role_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'login' => 'Login',
			'password' => 'Password',
			'nickname' => 'Nickname',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'phone' => 'Phone',
			'ip' => 'Ip',
			'role_id' => 'Role',
			'last_visited' => 'Last Visited',
			'baned' => 'Baned',
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
		$criteria->compare('login',$this->login,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('role_id',$this->role_id,true);
		$criteria->compare('last_visited',$this->last_visited,true);
		$criteria->compare('baned',$this->baned);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}