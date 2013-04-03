<?php

/**
 * This is the model class for table "voting_questions".
 *
 * The followings are the available columns in table 'voting_questions':
 * @property integer $id
 * @property string $voting_id
 * @property string $title
 * @property string $image
 * @property integer $visible
 * @property string $date
 */
class VotingQuestions extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VotingQuestions the static model class
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
		return 'voting_questions';
	}


    public  $count;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('voting_id', 'required'),
			array('visible,count', 'numerical', 'integerOnly'=>true),
			array('voting_id', 'length', 'max'=>10),
			array('title, image', 'length', 'max'=>255),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),
            array('date','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, voting_id, title, image, visible, date', 'safe', 'on'=>'search'),
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
            'answers'=> array(self::HAS_ONE, 'VotingAnswers','question_id'),
            'voting'=>array(self::BELONGS_TO, 'Voting', 'voting_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'voting_id' => 'Голосование',
			'title' => 'Вариант ответа',
			'image' => 'Фото',
			'visible' => 'Отображать',
			'date' => 'Date',
		);
	}
    private function tempToData($name){
        $tempPath = Yii::app()->params['tempPath'];
        if( file_exists($tempPath.$this->$name)){
            $dataPath =  Yii::app()->params['dataPath'];
            $originalPath =$dataPath.'votingQuestions/'.$this->id.'/images/'. $name .'/';
            if(!is_dir($originalPath)){
                Yii::app()->file->createDir(0777,$originalPath);
            }else{
                Yii::app()->file->set($originalPath)->delete(true);
                Yii::app()->file->createDir(0777,$originalPath);
            }
            Yii::import('common.ext.image.Image');
            Yii::app()->file->set($tempPath.$this->$name)->move($originalPath.$this->$name);
            $config = Yii::app()->params['VotingQuestions'][$name];
            $watermarkFile = $dataPath.'watermark.png';
            foreach($config['dimensions'] as $key=>$value){
                $Path = $originalPath .$key.'/';
                Yii::app()->file->createDir(0777,$Path);
                $image = new Image($originalPath.$this->$name);
                $image->resize($value['width'], $value['height'] , $value['type']);
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
        if(!empty($this->image)){
            $this->tempToData('image');
        }
        $answer = VotingAnswers::model()->findByAttributes(array('question_id'=>$this->id));
        if($answer){
            $answer->count = $this->count;
            $answer->update(array('count'));
        }else{
            $mod = new VotingAnswers();
            $mod->voting_id = $this->voting_id;
            $mod->question_id = $this->id;
            $mod->count = $this->count;
            $mod->save();
        }
        $answers= VotingAnswers::model()->findAllByAttributes(array('voting_id'=>$this->voting_id));
        if($answers){
            $totalCount = 0;
            foreach($answers as $val){
                $totalCount += $val->count;
            }
            Voting::model()->updateByPk($this->voting_id,array('count_vote'=>$totalCount));
        }
    }

    public static function getImageSrc($field,$size,$id,$file_name){
        return Yii::app()->params['dataUrl'] . 'votingQuestions/' . $id . '/images/' . $field . '/' . $size . '/' . $file_name;
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
        $criteria->with = array('voting');
        $criteria->together = true;
		$criteria->compare('id',$this->id);
		$criteria->compare('voting_id',$this->voting_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('visible',$this->visible);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}