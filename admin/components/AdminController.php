<?php

class AdminController extends Controller
{

 public $layout='//layouts/Column1';



    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('login'),
                'users'=>array('*'),
            ),
            array('allow',
                'roles'=>array('admin'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }
}