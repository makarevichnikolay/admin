<?php foreach ($announcements as $announcement): ?>
<div class="item-conteiner">
	<h4 class="text-h4">
		<?php
			$this->widget('common.modules.YOnixCommon.TimeAgo.TimeAgoWidget', array('dateString' => date_format($announcement->creation_date, "Y-m-d H:i")));
			if ($announcement->tournament_id) {
				// @todo hack
				echo CHtml::link($announcement->tournament->name, array('Tournament/view', 'id' => $announcement->tournament_id, 'url' => $announcement->tournament->url)) . ' : ';
			}
			echo CHtml::link($announcement->title, array('/Announcement/view', 'id' => $announcement->id, 'url' => $announcement->url));
		?>
		<a class="accordion-toggle" href="#annonce_<?php echo $announcement->id;?>" data-toggle="collapse"></a>
	</h4>

	<div id="annonce_<?php echo $announcement->id;?>" class="accordion-body item collapse ">
		<?php
		$this->beginWidget('frontend.components.LukMarkdownWidget');
		echo $announcement->getShortText();
		$this->endWidget();
		?>

		<div class="source">
		<?php
			if ($announcement->page_id) {
				echo CHtml::link($announcement->page->name, array('pages/ModulePageText/frontendIndex',
									'tournament_id' => $announcement->tournament_id,
									'tournament_url' => $announcement->url,
									'page_id' => $announcement->page_id,
									'page_url' => $announcement->page->url,
								));
			}
		?>
		</div>
		<div class="button-link">
			<?php
			$this->widget('bootstrap.widgets.TbButton', array(
				'label' => '<i class="icon-info-sign icon-white"></i> Подробнее&nbsp;',
				'encodeLabel' => false,
				'url' => array('/Announcement/view', 'id' => $announcement->id, 'url' => $announcement->url),
				'htmlOptions' => array('class' => 'pull-left'),
				'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size' => 'small', // '', 'large', 'small' or 'mini'
			));
			?>

			<div class="ico-comment">
				<div><?php echo  $count_comment = Comment::getCommentCount($announcement);?></div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>
<a href="<?=Yii::app()->CreateUrl('/Announcement/index')?>"><b>все анонсы...</b></a>