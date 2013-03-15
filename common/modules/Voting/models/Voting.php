<?php

/**
 * This is the model class for table "voting".
 *
 * The followings are the available columns in table 'voting':
 * @property integer $id
 * @property string $title
 * @property string $date
 * @property string $count_vote
 * @property integer $visible
 */
class Voting extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Voting the static model class
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
		return 'voting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title,question_vote', 'required'),
			array('visible', 'numerical', 'integerOnly'=>true),
			array('title,question_vote', 'length', 'max'=>255),
			array('count_vote', 'length', 'max'=>10),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),
			array('id, title, date, count_vote, visible,question_vote', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
            'questions'=>array(self::HAS_MANY, 'VotingQuestions','voting_id','with'=>array('answers'),'together'=>true),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
            'question_vote' => 'Вопрос',
			'date' => 'Date',
			'count_vote' => 'Количество проголосовавших',
			'visible' => 'Отображать',
		);
	}

    protected   function  beforeSave(){
        if($this->visible == 1){
            $voting = Voting::model()->findAllByAttributes(array('visible'=>1));
            foreach($voting as $vote){
                $vote->visible = 0;
                $vote->update(array('visible'));
            }
        }
        return  parent::beforeSave();
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
        $criteria->compare('question_vote',$this->question_vote);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('count_vote',$this->count_vote,true);
		$criteria->compare('visible',$this->visible);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}