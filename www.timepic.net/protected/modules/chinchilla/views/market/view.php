<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades'=>array('index'),
	$model->tradeId,
);

$this->menu=array(
	array('label'=>'List ChinchillaMarketTrade','url'=>array('index')),
	array('label'=>'Create ChinchillaMarketTrade','url'=>array('create')),
	array('label'=>'Update ChinchillaMarketTrade','url'=>array('update','id'=>$model->tradeId)),
	array('label'=>'Delete ChinchillaMarketTrade','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->tradeId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ChinchillaMarketTrade','url'=>array('admin')),
);
?>

<h1>View ChinchillaMarketTrade #<?php echo $model->tradeId; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'tradeId',
		'uid',
		'breed',
		'gender',
		'birthday',
		'weight',
		'ip',
		'description',
		'price',
		'pic',
		'dateline',
		'displayorder',
	),
)); ?>
