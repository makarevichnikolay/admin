<?php

class UsersController extends FrontendController
{

    public function actionLogin()
    {
        $model = new Users();
        $model->scenario = 'login';
        $result['success'] = false;
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->authenticate()) {
                $result['success'] = true;
            } else {
                $result['error'] = 'Неправильний логін або пароль';
            }
        }
        $result['error'] = 'Неправельний логін або пароль';
        header('Content-type: application/json');
        echo CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionRegister()
    {
        $this->title = "Реєстрація";
        $this->pageTitle = "Реєстрація";
        $model = new Users;
        $model->scenario = 'register';
        $emailSend = false;
        $this->performAjaxValidation($model);

        if (isset($_POST['Users'])) {
            $model->Attributes = $_POST['Users'];
            $model->role_id = 1;
            $newPass = Helper::random_password();
            $model->password = $newPass;
            $model->save();
            $to = $model->login;
            $from = Yii::app()->params['adminEmail'];
            $subj = "Акула - пароль для входу на сайт";
            $text = 'Ваш пароль: ' . $newPass . '';
            $mailer = Yii::createComponent('common.ext.mailer.EMailer');
            $mailer->From =  $from;
            $mailer->AddAddress($to);
            $mailer->CharSet = 'UTF-8';
            $mailer->Subject =  $subj;
            $mailer->Body = $text;
            $mailer->Send();
            Yii::app()->user->setFlash('success', '<strong>Дякуємо за реєстрацію. На вашу електронну адресу відправленний пароль для входу на сайт</strong>');
            $emailSend = true;
        }

        $this->render('register', array(
            'model' => $model,
            'emailSend'=>$emailSend
        ));
    }

    public function actionRemind()
    {
        $this->title = "Нагадування пароля";
        $this->pageTitle = "Нагадування пароля";
        $model = new Users;
        $emailSend = false;
        $this->performAjaxValidation($model);
        if (isset($_POST['Users'])) {
            $model->Attributes = $_POST['Users'];
            if ($model->validate()) {
                $user = Users::model()->findByAttributes(array('login' => $model->login));
                if ($user) {
                    $newPass = Helper::random_password();
                    $user->password = $newPass;
                    $user->update('password');
                    $to = $user->login;
                    $from = Yii::app()->params['adminEmail'];
                    $subj = "Акула - відновлення пароля";
                    $text = 'Ваш новий пароль: ' . $newPass . '';
                    $mailer = Yii::createComponent('common.ext.mailer.EMailer');
                    $mailer->From =  $from;
                    $mailer->AddAddress($to);
                    $mailer->CharSet = 'UTF-8';
                    $mailer->Subject =  $subj;
                    $mailer->Body = $text;
                    $mailer->Send();
                    Yii::app()->user->setFlash('success', '<strong>Відправленно!</strong>');
                    $emailSend = true;

                } else {
                    $model->addError('login', 'Користувач с таким E-Mail не зареєстрований');
                }
            }
        }

        $this->render('remind', array(
            'model' => $model,
            'emailSend' => $emailSend
        ));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->createUrl('Default/index'));
    }


    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }


    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'users-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
