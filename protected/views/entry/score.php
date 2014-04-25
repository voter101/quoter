<?php
/* @var $this EntryController */
/* @var $data Entry */
/**
 * @todo @fixme @enterprise This view made me cry about myself
 */
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
