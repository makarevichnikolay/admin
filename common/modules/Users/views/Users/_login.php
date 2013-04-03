<?php
// Yii::app()->clientScript->scriptMap['jquery.js'] = false;
if (Yii::app()->user->isGuest) {
    echo  CHtml::link('Вхід', '#', array('data-toggle' => 'modal', 'data-target' => '#login-modal'));
    ?>
&nbsp<a>|</a>
<?php
    echo  CHtml::link('Реєстрація', Yii::app()->createUrl('/Users/Users/register'), array());
} else {
    echo '<div class="user-name">' . Yii::app()->user->name . '</div>';
    echo CHtml::link('Выход', $this->createUrl('/Users/Users/Logout'));
}

?>
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'login-modal')); ?>
    <a class="close" data-dismiss="modal">&times;</a>
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
                        <input class="span12" name="Users[login]" type="text" placeholder="Електронна адреса">
                    </div>
                    <div class="row-fluid">
                        <div class="span7">
                            <input class="password" name="Users[password]" type="password" placeholder="Пароль">
                        </div>
                        <div class="span5">
                            <a id="login" href="#" class="pull-right main-btn enter">Вхід</a>
                        </div>

                    </div>
                    <div class="row-fluid">
                        <div class="span5 reg">
                            <?php  echo  CHtml::link('Реєстрація', Yii::app()->createUrl('/Users/Users/register'), array()); ?>
                        </div>
                        <div class="span7 remind">
                            <?php echo CHtml::link('Нагадати пароль',Yii::app()->createUrl('Users/Users/remind')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $this->endWidget(); ?>

<script type="text/javascript">

    $('#login').live('click', function () {
        var form = $('#userLogin');
        $.ajax({
            type:"POST",
            url:form.attr('action'),
            data:form.serialize()
        }).done(function (data) {
                if (data.success) {
                    window.location.href = '<?php echo Yii::app()->createUrl('/');?>';
                } else {
                    $('#userLogin-error').html(data.error);
                }
            });
        return false;
    })
</script>