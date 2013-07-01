<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades'=>array('index'),
	$model->tradeId=>array('view','id'=>$model->tradeId),
	'Update',
);

$this->menu=array(
	array('label'=>'List ChinchillaMarketTrade','url'=>array('index')),
	array('label'=>'Create ChinchillaMarketTrade','url'=>array('create')),
	array('label'=>'View ChinchillaMarketTrade','url'=>array('view','id'=>$model->tradeId)),
	array('label'=>'Manage ChinchillaMarketTrade','url'=>array('admin')),
);
?>

<h1>Update ChinchillaMarketTrade <?php echo $model->tradeId; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>