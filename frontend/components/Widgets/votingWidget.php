<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 26.02.13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */

class votingWidget extends CWidget
{

    public $header = 'Фото новина';
    public $class = 'head-photo';
    public $colors_class = array('danger','success','info','warning');

    public function run()
    {
        $cookie = isset(Yii::app()->request->cookies['voting']) ? Yii::app()->request->cookies['voting'] : false;
        print_r($cookie);
        echo 'sdf';
        Yii::app()->request->cookies['voting'] = new CHttpCookie('voting', 1);
        Yii::app()->getModule('Voting');
        $criteria = new CDbCriteria();
        $criteria->compare('t.visible', 1);
        $criteria->compare('questions.visible', 1);
        $criteria->together = true;
        $voting = Voting::model()->with(array('questions'))->find($criteria);
        if ($voting) {
            $html = '';
            if (!$cookie || $cookie != $voting->id) {
                $html .= CHtml::openTag('div', array('class' => 'voting'));
                $html .= CHtml::openTag('div', array('class' => 'title'));
                $html .= CHtml::openTag('i', array('class' => 'icon-vote')) . CHtml::closeTag('i');
                $html .= 'Опитування';
                $html .= CHtml::closeTag('div');
                $html .= CHtml::openTag('h5', array('class' => 'question')) . $voting->question_vote . CHtml::closeTag('h5');
                if ($voting->questions) {
                    $html .= CHtml::openTag('div', array('class' => 'answers'));
                    foreach ($voting->questions as $question) {
                        $html .= CHtml::openTag('div', array('class' => 'answer'));
                        if (!empty($question->image)) {
                            $html .= Chtml::image(VotingQuestions::getImageSrc('image', 'thumb', $question->id, $question->image));
                        }
                        $html .= CHtml::openTag('div', array('class' => 'answer-text')) . CHtml::radioButton('questions') . $question->title . CHtml::closeTag('div');
                        $html .= CHtml::closeTag('div');
                    }
                    $html .= CHtml::closeTag('div');
                }
                $html .= CHtml::closeTag('div');


            } else {
                $html .= CHtml::openTag('div', array('class' => 'voting'));
                $html .= CHtml::openTag('div', array('class' => 'title'));
                $html .= CHtml::openTag('i', array('class' => 'icon-vote')) . CHtml::closeTag('i');
                $html .= 'Опитування';
                $html .= CHtml::closeTag('div');
                $html .= CHtml::openTag('h5', array('class' => 'question')) . $voting->question_vote . CHtml::closeTag('h5');
                if ($voting->questions) {
                    $html .= CHtml::openTag('div', array('class' => 'answers'));
                    $i =0;
                    foreach ($voting->questions as $question) {
                        if($i>count($this->colors_class))
                            $i = 0;
                        $html .= CHtml::openTag('div', array('class' => 'answer clearfix'));
                        if (!empty($question->image)) {
                            $html .= Chtml::image(VotingQuestions::getImageSrc('image', 'thumb', $question->id, $question->image));
                        }
                        $html .= CHtml::openTag('div', array('class' => 'answer-text'))  . $question->title . CHtml::closeTag('div');

                        if(isset($question->answers))
                             $count = (round($question->answers->count/$voting->count_vote,1)*100);
                        else
                             $count=0;
                        $html .= CHtml::openTag('div',array('class'=>'percent')). $count.'%'.CHtml::closeTag('div');
                        $html .= CHtml::openTag('div',array('class'=>'result')). $this->widget('bootstrap.widgets.TbProgress', array(
                            'type'=>$this->colors_class[$i++],
                            'percent'=>  $count ,
                            'striped'=>false,
                            'animated'=>false,
                        ),true). CHtml::closeTag('div');;
                        $html .= CHtml::closeTag('div');
                    }
                    $html .= CHtml::closeTag('div');
                    $html .= CHtml::openTag('div',array('class'=>'vote-count')).'Всього голосів: '.$voting->count_vote. CHtml::closeTag('div');
                }
                $html .= CHtml::closeTag('div');

            }
        echo $html;
        }

    }

}

?>