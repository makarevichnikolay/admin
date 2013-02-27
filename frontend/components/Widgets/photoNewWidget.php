<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 26.02.13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */

class photoNewWidget extends CWidget{

    public function run() {
        $criteria= new CDbCriteria();
        $criteria->limit = 1;
        $criteria->compare('photo_new',1);
        $criteria->addCondition('main_image != ""');
        $criteria->order = 'date_create,date_update';
        $page = Pages::model()->find($criteria);

    }
}
?>