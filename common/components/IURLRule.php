<?php

interface IURLRule {
   public function createUrlF($manager,
      $route, $params, $ampersand);
   public function parseUrlF($manager,
      $request, $pathInfo, $rawPathInfo);  
}