        <?php
       // Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        if (Yii::app()->user->isGuest) {
            echo  CHtml::link('Вхід', '#', array(
                'data-content' => $this->renderPartial('common.modules.Users.views.Users._loginForm',null,true,false),
                'data-placement' => 'bottom',
                'data-html' => true,
                'rel' => 'popover'
            ));
            ?>
            <a>|</a>
            <a href="#">Реєстрація</a>
            <?php
        } else {
            echo Yii::app()->user->name;
            echo CHtml::link('Выход', $this->createUrl('Users/Users/Logout'));
        }
        ?>

        <script type="text/javascript">
            $('#login').live('click',function(){
                userLogin('userLogin','<?php echo Yii::app()->createUrl('/');?>','userLogin-error');
                return false;
            })
        </script>