<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ChinchillaMarketTrade','url'=>array('index')),
	array('label'=>'Manage ChinchillaMarketTrade','url'=>array('admin')),
);
?>

<h1>分享龙猫信息</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>