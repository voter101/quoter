<?php
$cs = Yii::app()->getClientScript();
$baseUrl = Yii::app()->baseUrl;
$cs->registerCssFile($baseUrl . '/css/style.css');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
<div id="wrapper">
	<header>
		<?php echo CHtml::link("<h1>" . Yii::app()->name . "</h1>", Yii::app()->getBaseUrl(true)); ?>
		<nav>
			<?php
			$this->widget('zii.widgets.CMenu', array(
				'items' => array(
					array(
						'label' => Yii::t("menu.add", "Add entry"),
						'url' => array('/entry/add')
					),
					array(
						'label' => Yii::t("menu.new", "New entries"),
						'url' => array('/new')
					),
					array(
						'label' => Yii::t("menu.top", "Top entries"),
						'url' => array('/top')
					),
					array(
						'label' => Yii::t("menu.bottom", "Worst entries"),
						'url' => array('/bottom')
					),
					array(
						'label' => Yii::t("menu.archive", "Old entries"),
						'url' => array('/old')
					),
				),
			));
			?>
		</nav>
	</header>
	<section id="content">
		<?php echo $content ?>
	</section>
	<footer>
		<span class="copyright"><?php echo Yii::app()->name; ?> &copy; <?php echo date('Y'); ?></span>
	</footer>
</div>
</body>
</html>
