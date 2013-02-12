<?php
    $item_data = DefaultController::getItemData($data['item_id'],$data['words']);
    ?>
    <div style="border:1px solid red;margin: 5px;">
        <ul>
            <li> <?php echo $data['count']; ?></li>
            <li> <?php echo $data['words']; ?></li>
            <li> <?php echo $data['item_id']; ?></li>
            <li><?php  echo $item_data ?></li>

        </ul>

    </div>


