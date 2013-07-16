<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh-CN" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<?php Yii::app()->bootstrap->register(); ?>
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/ieltseye.css"); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/backtotop.js",CClientScript::POS_END); ?>

</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'fixed' => false,
    'fluid'=> false,
    'collapse'=>true,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>'Home', 'url'=>array('/')),
            ),
        ),
    ),
)); ?>

<div class="row-fluid" id="header"></div>
<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'homeLink'=>  CHtml::link('Home', Yii::app()->params['ieltseye']['homeUrl']),
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
    
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by IELTSEYE.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
