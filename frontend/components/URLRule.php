<?php
class URLRule extends CBaseUrlRule
{

   private static function getModuleComponent($module) {
      return Yii::app()->getModule($module);
   }


   public function createUrl($manager,$route,$params,$ampersand) {
       $routeData = explode('/',$route);
       if($routeData[0] == Yii::app()->params['defaultModule']){
           $module = self::getModuleComponent($routeData[0]);
           if($module instanceof IURLRule) {
               return $module->createUrlF($manager,$route,$params,$ampersand);
           }
       }

      return false;
   }



   public function parseUrl($manager,$request,$pathInfo,$rawPathInfo) {
      $module = self::getModuleComponent('Pages');
      if($module instanceof IURLRule) {
         return $module->parseUrlF($manager,$request,$pathInfo,$rawPathInfo);
      }
      return false; 
   }
}