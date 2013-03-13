        <?php
       // Yii::app()->clientScript->scriptMap['jquery.js'] = false;
        if (Yii::app()->user->isGuest) {
            echo  CHtml::link('Вхід', '#', array('class'=>'open-login-form'));
            ?>
            <a>|</a>
            <?php
            echo  CHtml::link('Реєстрація', Yii::app()->createUrl('/Users/Users/register'), array());
        } else {
            echo '<div class="user-name">'.Yii::app()->user->name.'</div>';
            echo CHtml::link('Выход', $this->createUrl('/Users/Users/Logout'));
        }
        ?>
        <div class="login-form">
            <form action="<?php echo Yii::app()->createUrl('Users/Users/Login');?>" id="userLogin">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="row-fluid error">
                            <div class="span12">
                                <div id="userLogin-error"></div>
                            </div>
                        </div>
                        <div class="row-fluid">
                            <input class="span12" name="Users[login]" type="text">
                        </div>
                        <div class="row-fluid">
                            <div class="span7">
                                <input class="password" name="Users[password]" type="password">
                            </div>
                            <div class="span5">
                                <a id="login" href="#" class="pull-right main-btn enter">Вхід</a>
                            </div>

                        </div>
                        <div class="row-fluid remind">
                            <input class="" name="Users[save]" type="checkbox"><span>Запам’ятати</span>
                            <a  href="#" class="">Нагадати пароль</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            $('.open-login-form').live('click',function(){
                $('.login-form').toggle();
            });
            $('#login').live('click',function(){
                    var form = $('#userLogin');
                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
                        data:form.serialize()
                    }).done(function( data ) {
                            if(data.success){
                                window.location.href = '<?php echo Yii::app()->createUrl('/');?>';
                            }else{
                                $('#userLogin-error').html(data.error);
                            }
                        });
                return false;
            })
        </script>