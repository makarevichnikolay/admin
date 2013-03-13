<?php

/**
 * This is the model class for table "categories".
 *
 * The followings are the available columns in table 'categories':
 * @property integer $id
 * @property string $title
 */
class Feadback extends CFormModel {

    public $name;
    public $lastName;
    public $about;
    public $email;
    public $phone;
    public $file;
    public $image;


    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name,lastName,about,email', 'required','message'=>'Обов\'язкове для заповнення!'),
            array('email','email','message'=>'Введіть E-mail!'),
            array('phone','type', 'type'=>'string'),
            array('file', 'file', 'allowEmpty' => true, 'types' => 'doc, docx, pdf, txt'),
            array('image', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Ім\'я',
            'lastName'=>'Прізвище',
            'about'=>'Коротко про себе',
            'email'=>'E-mail',
            'phone'=>'Телефон',
            'file' =>'Файл(doc, docx, pdf, txt)',
            'image'=>'Фото автора'


        );
    }

}