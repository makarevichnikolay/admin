<?php

class DefaultController extends AdminController
{

public $replace = array('#','!', ')','(',',',';',':','+','\'','&','"','?');
public $special_replace = array('.','nbsp','quot','ndash','raquo','laquo','-','mdash','/','  ','   ','    ','#','!', ')','(',',',';',':','+','&','"','?');
public $stopWords = array(
'что', 'как', 'все', 'она', 'так', 'его', 'только', 'мне', 'было', 'вот',
'меня', 'еще', 'нет', 'ему', 'теперь', 'когда', 'даже', 'вдруг', 'если',
'уже', 'или', 'быть', 'был', 'него', 'вас', 'нибудь', 'опять', 'вам', 'ведь',
'там', 'потом', 'себя', 'может', 'они', 'тут', 'где', 'есть', 'надо', 'ней',
'для', 'тебя', 'чем', 'была', 'сам', 'чтоб', 'без', 'будто', 'чего', 'раз',
'тоже', 'себе', 'под', 'будет', 'тогда', 'кто', 'этот', 'того', 'потому',
'этого', 'какой', 'ним', 'этом', 'один', 'почти', 'мой', 'тем', 'чтобы',
'нее', 'были', 'куда', 'зачем', 'всех', 'можно', 'при', 'два', 'другой',
'хоть', 'после', 'над', 'больше', 'тот', 'через', 'эти', 'нас', 'про', 'них',
'какая', 'много', 'разве', 'три', 'эту', 'моя', 'свою', 'этой', 'перед',
'чуть', 'том', 'такой', 'более', 'всю'
);
   private $connection;


	public function actionIndex()
	{
        $start = microtime(true);
        if(!$this->connection)
            $this->connection=Yii::app()->db;


        $max_item_for_word = 30;
        $max_insert = 1000;
        $i = 0;
        $words = array();
        $data = $this->getWords();
        foreach($data as  $val){
            $id = $val['id'];
            $text = strip_tags($val['content']);
            $text = str_replace($this->special_replace,' ',$text);
            $text = preg_replace ("/[^a-zA-ZА-ЯІЇЄҐа-яіїєґ0-9\s\t\r\n]/iu","",$text);
            $text = preg_replace("/(\s|\t|\r|\n|\v|\e)+/iu", " ", $text);
            $text = preg_replace("/(\s)+/iu", " ", $text);
            $text = mb_strtolower($text,'utf8');
            $text = explode(' ',$text);
            foreach($text as $word){
                $word = trim($word);
               if(empty($word) || mb_strlen($word,'utf8') <= 2 || in_array($word, $this->stopWords)){
                    continue;
                }else{
                   if(array_key_exists($word,$words)){
                       if(array_key_exists($id,$words[$word])){
                               $words[$word][$id] =  $words[$word][$id]+1;
                       }else{
                           if(count($words[$word]) <= $max_item_for_word){
                               $words[$word][$id]= 1;
                           }else{
                               continue;
                           }
                       }
                   }else{
                       $words[$word] = array($id=>1);
                   }
               }
            }
            $i++;
            //if($i>1000)
                //break;
        }
        echo '<pre>';
        echo count($words);
        //ksort($words);
        //print_r($words);
        echo '</pre>';
        $command=$this->connection->createCommand('TRUNCATE TABLE search_words');
        $command->execute();
        $command=$this->connection->createCommand('TRUNCATE TABLE search_data');
        $command->execute();
        $words_sql = 'INSERT INTO search_words(id,word) VALUES';
        $j=$jj= 0;
        $word_data_sql = 'INSERT INTO search_data(word_id,item_id,count) VALUES';
        foreach($words as $key=>$value){
            $j++;
            $jj++;
            $words_sql .= '('.$j.',"'.$key.'"),';
            foreach($value as $id=>$count){
                $word_data_sql .= '('.$j.','.$id.','.$count.'),';
            }
            if($jj>=$max_insert){
                $jj = 0;
                $word_data_sql = $this->wordDataInsert($word_data_sql);
                $words_sql = $this->wordsInsert($words_sql);
            }
        }
        $this->wordDataInsert($word_data_sql);
        $this->wordsInsert($words_sql);

        echo $i.'<br>';
        echo 'time:'.(microtime(true) - $start).'<br />';
        echo 'mem:' . round((memory_get_usage()/1024)/1024).'M | pick' .  round((memory_get_peak_usage()/1024)/1024).'M';
		//$this->render('index');
	}
    private function getWords(){
        $sql = "SELECT id,content FROM pages";
        $command=$this->connection->createCommand($sql);
        return $command->queryAll();
    }

    private function wordsInsert($words_sql){
        $words_sql = substr($words_sql,0,(strlen($words_sql)-1));
        $words_sql .= ';';
        $command=$this->connection->createCommand($words_sql);
        $command->execute();
        return  'INSERT INTO search_words(id,word) VALUES';
    }

    private function wordDataInsert($word_data_sql){
        $word_data_sql = substr($word_data_sql,0,(strlen($word_data_sql)-1));
        $word_data_sql .= ';';
        $command=$this->connection->createCommand($word_data_sql);
        $command->execute();
        return 'INSERT INTO search_data(word_id,item_id,count) VALUES';
    }




}