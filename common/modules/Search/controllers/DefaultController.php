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
            $text = strip_tags($val['body']);
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
        $sql = "SELECT id,body FROM news";
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

    private function getWordSearch($word){
        $sql = "SELECT * FROM search_words LEFT JOIN search_data  ON search_words.id = search_data.word_id WHERE word LIKE '".$word."%' ORDER BY search_data.count DESC";
        //$command=$this->connection->cache(1000)->createCommand($sql);
        $command=$this->connection->createCommand($sql);
        return $command->queryAll();
    }

    public static  function getItemData($id,$words){
        $connection=Yii::app()->db;
        $sql = "SELECT body FROM news WHERE id =".$id;
        $command=$connection->createCommand($sql);
        $row=$command->query()->readAll();
        $body = strip_tags($row[0]['body']);
        $words = explode(' ',$words);
        $len_text = 800;
        foreach($words as $word){
            if(preg_match('#'.$word.'#ui',$body,$match,PREG_OFFSET_CAPTURE)){
                if($match[0][1] <= $len_text/2)
                    $pos = 0;
                else
                    $pos = $match[0][1] - $len_text/2;
                $body = mb_strcut($body,$pos,$len_text,'utf8');
                break;
            }
        }
        foreach($words as $word){
            $body = preg_replace('#([^a-zA-ZА-ЯІЇЄҐа-яіїєґ])('.$word.')([^a-zA-ZА-ЯІЇЄҐа-яіїєґ<])#ui',' $1<code>'.$word.'</code>$3',$body);
        }
        return $body;
   }

    private  function mergeDataSearch($words_result){
        $data = array();
        foreach($words_result as $key=>$value){
            foreach($value as $item){
                if(array_key_exists($item['item_id'],$data)){
                     if($key>$data[$item['item_id']]['highPriority']){
                          $data[$item['item_id']]['count'] =  $data[$item['item_id']]['count'] +1000;
                          $data[$item['item_id']]['highPriority'] = $key;
                     }
                     $data[$item['item_id']]['count'] = $data[$item['item_id']]['count'] +$item['count'];
                     $data[$item['item_id']]['words'] = $data[$item['item_id']]['words'].' '.$item['word'];
                }else{
                    $data[$item['item_id']] = array(
                        'count'=>$item['count'],
                        'words'=>$item['word'],
                        'item_id'=>$item['item_id'],
                        'highPriority'=>$key
                    );
                }
            }
        }
        return $data;
    }

    public function actionSearch(){
        if(!$this->connection)
            $this->connection=Yii::app()->db;
        $words = 'пограбування скоєне кіровограді';
        $start = microtime(true);
        $words_result =array();
        $words  = mb_strtoupper($words,'utf8');
        $words_array = explode(' ',$words);
        $morth_words = Yii::app()->morphy->getPseudoRoot($words_array);
        //echo '<pre>';
        //print_r($morth_words);
       // echo '</pre>';
        foreach($morth_words as $origin_word => $item){
            if(mb_strlen($item[0],'utf8')<3){
                $word = $origin_word;
            }else{
                $word = $item[0];
            }
            $words_result[]=$this->getWordSearch($word);
        }
       // echo '<pre>';
        //print_r($words_result);
       // echo '</pre>';
        $items = $this->mergeDataSearch($words_result);
        usort($items,function($a, $b){
            if ($a['count'] == $b['count']) {
                return 0;
            }
            return ($a['count'] < $b['count']) ? 1 : -1;
        });
        $itemsProvider = new CArrayDataProvider($items, array(
            'keyField'   => 'count',
            'pagination' => array(
                'pageSize'=>5,
            )));
        echo 'time:'.(microtime(true) - $start).'<br />';
        if(isset($_GET['ajax'])){
            $this->renderPartial('index',array('itemsProvider'=>$itemsProvider));
            Yii::app()->end();
        }

        $this->render('index',array('itemsProvider'=>$itemsProvider));
    }
}