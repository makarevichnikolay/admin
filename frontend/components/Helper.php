<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 26.02.13
 * Time: 14:55
 * To change this template use File | Settings | File Templates.
 */
class Helper{

    public static function cutStr($str,$len){
          if(mb_strlen($str,'utf8')<$len)
              return $str;
          return  preg_replace('/\s[^\s]+$/', '', mb_substr($str, 0, $len,'utf8')).'...';
    }

}
