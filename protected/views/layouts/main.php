<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
    <div id="wrapper">
        <header>
            <?php echo CHtml::link("<h1>". Yii::app()->name ."</h1>", Yii::app()->request->baseUrl); ?>
        </header>
        <nav>
            <?php
            $this->widget('zii.widgets.CMenu', array(
               'items' => array(
                    array('label' => Yii::t("menu.add", "Add entry"), 'url' => array('/entry/add')),
                    array('label' => Yii::t("menu.new", "New entries"), 'url' => array('/entry/new')),
                    array('label' => Yii::t("menu.top", "Top entries"), 'url' => array('/entry/top')),
                    array('label' => Yii::t("menu.bottom", "Worst entries"), 'url' => array('/entry/bottom')),
                    array('label' => Yii::t("menu.archive", "Old entries"), 'url' => array('/entry/archive')),
               ),
            ));
            ?>
        </nav>
	    <section id="content">
		    <?php echo $content ?>
	    </section>
	    <footer>
		    <span class="copyright">Copyright &copy; <?php echo date('Y'); ?></span>
	    </footer>
    </div>
</body>
</html>
