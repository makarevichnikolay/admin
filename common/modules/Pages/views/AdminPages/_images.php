<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Veha
 * Date: 24.01.13
 * Time: 11:58
 * To change this template use File | Settings | File Templates.
 */
?>

    <li class="images-box">
        <div class="thumbnail">
            <img src="http://placehold.it/280x180" alt="">
            <?php
            echo Chtml::beginForm();
            ?>
            <fieldset>
            <?php
            echo CHtml::textField('title');
            echo CHtml::endForm();
            ?>
                </fieldset>

        </div>
    </li>
