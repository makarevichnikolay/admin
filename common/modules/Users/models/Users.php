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

    public $password_repeat;
    public $date_from;
    public $date_to;

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

			array('login', 'required'),
            array('login','email'),
			array('baned,role_id', 'numerical', 'integerOnly'=>true),
            array('first_name, last_name, phone, ip', 'type', 'type'=>'string'),
			array('login, password, nickname, first_name, last_name, phone, ip', 'length', 'max'=>255),
			array('role_id', 'length', 'max'=>10),
			array('id, login, password, nickname, first_name, last_name, phone, ip, role_id, last_visited, baned, date_from, date_to', 'safe', 'on'=>'search'),
            array('password_repeat,	nickname', 'required', 'on'=>'register'),
            array('password_repeat', 'compare', 'compareAttribute'=>'password', 'on'=>'register'),
            array('password_repeat,password', 'required', 'on'=>'register'),
            array('password', 'required', 'on'=>'login'),
            array('nickname, baned,role_id,first_name, last_name, phone, ip, last_visited, password_repeat', 'safe','on'=>'login'),

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
			'login' => 'Email',
			'password' => 'Пароль',
			'nickname' => 'Никнейм',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'phone' => 'Телефон',
			'ip' => 'Ip',
			'role_id' => 'Тип пользователя',
			'last_visited' => 'Дата посещения',
			'baned' => 'Забанен',
		);
	}

    public function authenticate(){
        $identity=new UserIdentity($this->login,$this->password);
        if($identity->authenticate()){
            Yii::app()->user->login($identity);
            return true;
        }
        return false;
    }


   public static function GetRealIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
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
        $criteria->with = array('role');
        $criteria->together= true;
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
        if((isset($this->date_from) && trim($this->date_from) != "") && (isset($this->date_to) && trim($this->date_to) != ""))
            $criteria->addBetweenCondition('last_visited', ''.$this->date_from.'', ''.$this->date_to.'');

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}