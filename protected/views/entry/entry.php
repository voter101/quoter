<?php
/* @var $this EntryController */
/* @var $data Entry */
Yii::app()->getClientScript()->registerScriptFile(Yii::app()->baseUrl . '/js/entryVote.js');
?>
<article data-id="<?php echo $data->id ?>" class="entry">

	<section class="info">
		<span class="id">
			<?php
			echo CHtml::link(CHtml::encode('#' . $data->id), array(
				'view',
				'id' => $data->id
			));
			?>
		</span>
		<span class="score">
			<?php
			$cookieSign = EntryScoreManager::GetVoteCookieSign($data->id);
			$voteDownHtmlOptions = array(
				'class' => 'voteDown',
				'data-id' => $data->id,
			);
			if ($cookieSign === 0) {
				$voteDownHtmlOptions['style'] = "display:none;";
			}
			echo CHtml::link(Yii::t("Entry.voteDown", "-"), array(
				'entry/vote',
				'id' => $data->id,
				'positive' => 0,
			), $voteDownHtmlOptions);
			?>
			<span class="number"><?php echo CHtml::encode($data->score); ?></span>
			<?php
			$voteUpHtmlOptions = array(
				'class' => 'voteUp',
				'data-id' => $data->id,
			);
			if ($cookieSign === 1) {
				$voteUpHtmlOptions['style'] = "display:none;";
			}
			echo CHtml::link(Yii::t("Entry.voteUp", "+"), array(
				'entry/vote',
				'id' => $data->id,
				'positive' => 1,
			), $voteUpHtmlOptions);
			?>
			<span class="voteMessage"></span>
		</span>
		<span class="datetime">
			<?php
			if ($data->modified == null) {
				echo CHtml::encode($data->created);
			} else {
				echo CHtml::encode($data->modified);
			}
			?>
		</span>
	</section>
	<p>
		<?php echo nl2br(CHtml::encode($data->content)); ?>
	</p>
	<?php
	if ($data->author) : ?>
		<span class="author">
				<?php echo CHtml::encode($data->author); ?>
		</span>
	<?php endif; ?>

</article>