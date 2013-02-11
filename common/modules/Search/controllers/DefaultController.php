<?php

class DefaultController extends Controller
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


	public function actionIndex()
	{
        $start = microtime(true);
        print_r(Yii::app()->morphy->getPseudoRoot(array('ВАШИМ','МОВИ','РОБОТОЮ')));
        echo '<br>'.'timeMorthy:'.(microtime(true) - $start).'<br />';
        $connection=Yii::app()->db;
        $sql = "SELECT id,body FROM news";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
        $max_item_for_word = 50;
        $i = 0;
        $words = array();
        foreach($dataReader as $key => $val){
            $id = $val['id'];
            $text = strip_tags($val['body']);
            $text = str_replace($this->special_replace,' ',$text);
            $text = preg_replace ("/[^a-zA-ZА-ЯІЇЄҐа-яіїєґ0-9\s\t\r\n]/iu","",$text);
            $text = preg_replace("/(\s|\t|\r|\n|\v|\e)+/iu", " ", $text);
            $text = preg_replace("/(\s)+/iu", " ", $text);

           // $aux = utf8_strip_specials($text, ' ');
            $text = mb_strtolower($text,'utf8');
            $text = explode(' ',$text);
            foreach($text as $k =>$word){
                $word = trim($word);
               if(empty($word) || mb_strlen($word,'utf8') <= 2 || in_array($word, $this->stopWords)){
                    continue;
                }else{
                   if(array_key_exists($word,$words)){
                       if(array_key_exists( $id,$words[$word])){
                               $words[$word][$id] =  $words[$word][$id]+1;
                       }else{
                           if(count($words[$word]) <= $max_item_for_word)
                              $words[$word][$id]=1;
                       }
                   }else{
                       $words[$word] = array($id=>1);
                   }
               }
            }
         $i++;
            if($i > 10000)
                break;
        }
        echo '<pre>';
        echo count($words);
        //ksort($words);
        //print_r($words);
        echo '</pre>';
        $words_sql = 'INSERT INTO search_words(word) VALUES';
        $j=$jj= 0;
        $word_data_sql = 'INSERT INTO search_data(word_id,item_id,count) VALUES';
        foreach($words as $key=>$value){
            $j++;
            $jj++;
            $words_sql .= '("'.$key.'"),';
            foreach($value as $id=>$count){
                $word_data_sql .= '('.$j.','.$id.','.$count.'),';
            }
            if($jj>=1000){
                $jj = 0;
                $word_data_sql = substr($word_data_sql,0,(strlen($word_data_sql)-1));
                $word_data_sql .= ';';
                $command=$connection->createCommand($word_data_sql);
                $rowCount=$command->execute();
                $word_data_sql = 'INSERT INTO search_data(word_id,item_id,count) VALUES';

                $words_sql = substr($words_sql,0,(strlen($words_sql)-1));
                $words_sql .= ';';
                $command=$connection->createCommand($words_sql);
                $rowCount=$command->execute();
                $words_sql = 'INSERT INTO search_words(word) VALUES';
            }
        }



        echo $i.'<br>';
      echo 'time:'.(microtime(true) - $start).'<br />';
      echo 'mem:' . round((memory_get_usage()/1024)/1024).'M | pick' .  round((memory_get_peak_usage()/1024)/1024).'M';
		//$this->render('index');
	}

    public function actionSearch(){
        $start = microtime(true);
        $word = 'кіровоград';
        $connection=Yii::app()->db;
        $sql = "SELECT * FROM search_words LEFT OUTER JOIN search_data  ON search_words.id = search_data.word_id WHERE word LIKE '".$word."%' ORDER BY search_data.count DESC LIMIT 10";
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();
        foreach($dataReader as $val){
            echo $val['word'].'|'.$val['item_id'].'|'.$val['count'].'<br>';
        }
        echo 'time:'.(microtime(true) - $start).'<br />';
    }
}