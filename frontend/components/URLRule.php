<?php
class URLRule extends CBaseUrlRule
{

   private static function getModuleComponent($module) {
      return Yii::app()->getModule($module);
   }


   public function createUrl($manager,$route,$params,$ampersand) {
       $routeData = explode('/',$route);
       if($routeData[0] == 'Pages'){
           $module = self::getModuleComponent($routeData[0]);
           if($module instanceof IURLRule) {
               $res = $module->createUrlF($manager,$route,$params,$ampersand);
              if($res){
                  return $res;
              }
           }
       }
       if($routeData[0] == 'StaticPages'){
           $module = self::getModuleComponent($routeData[0]);
           if($module instanceof IURLRule) {
               $res = $module->createUrlF($manager,$route,$params,$ampersand);
               if($res){
                   return $res;
               }
           }
       }

      return false;
   }



   public function parseUrl($manager,$request,$pathInfo,$rawPathInfo) {
      $module = self::getModuleComponent('Pages');
      if($module instanceof IURLRule) {
          $res = $module->parseUrlF($manager,$request,$pathInfo,$rawPathInfo);
         if($res)
             return $res;
      }
       $module = self::getModuleComponent('StaticPages');
       if($module instanceof IURLRule) {
           $res = $module->parseUrlF($manager,$request,$pathInfo,$rawPathInfo);
           if($res)
               return $res;
       }
      return false; 
   }
}