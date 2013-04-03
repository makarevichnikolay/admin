<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 13.02.13
 * Time: 11:11
 * To change this template use File | Settings | File Templates.
 */

class SearchController extends FrontendController
{

    public $connection;


    public function actionSearch(){
        if(!$this->connection)
            $this->connection=Yii::app()->db;
        $items = $params = array();
        $words = '';
        if(isset($_POST['SearchWords'])){
            $words = $_POST['SearchWords']['word'];
            $params =array('SearchWords'=>$_POST['SearchWords']);
        }elseif(isset($_GET['SearchWords'])){
            $words = $_GET['SearchWords']['word'];
            $params =array('SearchWords'=>$_GET['SearchWords']);
        }
        if(!empty($words)){
            //$start = microtime(true);
            $words_result =array();
            $words = strip_tags($words);
            $words  = preg_replace ("/[^a-zA-ZА-ЯІЇЄҐа-яіїєґ0-9\s\t\r\n]/iu","",$words );
            $words  = preg_replace("/(\s|\t|\r|\n|\v|\e)+/iu", " ", $words );
            $words  = preg_replace("/(\s)+/iu", " ", $words );
            $words  = mb_strtoupper($words,'utf8');
            $words_array = explode(' ',$words);
            foreach($words_array as $key=>$val){
                if(empty($val) || mb_strlen($val,'utf8')<3)
                    unset($words_array[$key]);
            }
            $morth_words = Yii::app()->morphy->getPseudoRoot($words_array);
            foreach($morth_words as $origin_word => $item){
                if(mb_strlen($item[0],'utf8')<3){
                    $word = $origin_word;
                }else{
                    $word = $item[0];
                }
                $words_result[]=$this->getWordSearch(mb_strtolower($word,'utf8'));
            }
            $items = $this->mergeDataSearch($words_result);
            usort($items,function($a, $b){
                if ($a['count'] == $b['count']) {
                    return 0;
                }
                return ($a['count'] < $b['count']) ? 1 : -1;
            });

            //echo 'time:'.(microtime(true) - $start).'<br />';
        }
        $itemsProvider = new CArrayDataProvider($items, array(
            'keyField'   => 'count',
            'pagination' => array(
                'pageSize'=>5,
                'params'=>$params
            )));
        if(isset($_GET['ajax'])){
            $this->renderPartial('index',array('itemsProvider'=>$itemsProvider));
            Yii::app()->end();
        }

        $this->render('index',array('itemsProvider'=>$itemsProvider));
    }

    private function getWordSearch($word){
        $sql = "SELECT * FROM search_words LEFT JOIN search_data  ON search_words.id = search_data.word_id WHERE word LIKE '".$word."%' ORDER BY search_data.count DESC";
        //$command=$this->connection->cache(1000)->createCommand($sql);
        $command=$this->connection->createCommand($sql);
        return $command->queryAll();
    }

    public static  function getItemData($id,$words){
        $connection=Yii::app()->db;
        $sql = "SELECT content,title,url,main_image,id,date,author_name FROM pages WHERE id =".$id;
        $command=$connection->createCommand($sql);
        $row=$command->query()->readAll();
        if(isset($row[0])){
            $data['id'] = $row[0]['id'];
            $data['main_image'] = $row[0]['main_image'];
            $data['title'] = $row[0]['title'];
            $data['url'] = $row[0]['url'];
            $data['date'] = $row[0]['date'];
            $data['author_name'] = $row[0]['author_name'];
            $body = strip_tags($row[0]['content']);
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
            $data['body'] =  $body;
            return  $data;
        }else{
            return false;
        }

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



}