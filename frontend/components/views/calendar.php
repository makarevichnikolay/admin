


<center>
	<h3>Календарь</h3>
<div class="Calendar">
<?php
	Yii::app()->controller->renderPartial('generate_calendar');
echo generate_calendar($year, $month, $days, $len, $url, 0, $pnc);
?>
</div>
</center>


