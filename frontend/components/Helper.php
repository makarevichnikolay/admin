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

    public static  function sendMail($to, $from, $subj, $text, $files=null){
        $boundary = md5(uniqid(time()));
        $headers[] ="MIME-Version: 1.0";
        $headers[] ="Content-Type: multipart/mixed;boundary=\"$boundary\"; type=\"text/html;\"";
        $headers[] ="From: ".$from;
        $headers[] ="Reply-To: ".$from;
        $headers[] ="Return-Path: ".$from;
        $headers[] ="X-Mailer: PHP/" . phpversion();

        $multipart[]= "--".$boundary;
        $multipart[]= "Content-Type: text/html; charset=utf-8";
        $multipart[]= "Content-Transfer-Encoding: Quot-Printed";
        $multipart[]= ""; // раздел между заголовками и телом html-части
        $multipart[]= $text;
        $multipart[]= "";

        if ((is_array($files))&&(!empty($files)))
        {
            foreach($files as $filename => $filecontent)
            {
                $multipart[]="--".$boundary;
                $multipart[]= "Content-Type: application/octet-stream; name=\"".$filename."\"";
                $multipart[]= "Content-Transfer-Encoding: base64";
                $multipart[]= "Content-Disposition: attachment; filename=\"".$filename."\"";
                $multipart[]= "";
                $multipart[]= chunk_split(base64_encode($filecontent));
            }
        }

        $multipart[]= "--$boundary--";
        $multipart[]= "";
        $headers=implode("\r\n", $headers);
        $multipart=implode("\r\n", $multipart);
        if (mb_detect_encoding($subj, "UTF-8")==FALSE)
            $subj= mb_encode_mimeheader($subj,"UTF-8", "B", "\n");

        return mail($to, $subj, $multipart, $headers);
    }

    public  static function random_password($length = 8, $allow_uppercase = true, $allow_numbers = true)
    {
        $out = '';
        $arr = array();
        for($i=97; $i<123; $i++) $arr[] = chr($i);
        if ($allow_uppercase) for($i=65; $i<91; $i++) $arr[] = chr($i);
        if ($allow_numbers) for($i=0; $i<10; $i++) $arr[] = $i;
        shuffle($arr);
        for($i=0; $i<$length; $i++)
        {
            $out .= $arr[mt_rand(0, sizeof($arr)-1)];
        }
        return $out;
    }

}
