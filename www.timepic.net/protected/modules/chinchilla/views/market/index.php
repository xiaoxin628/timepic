<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades',
);

$this->menu=array(
	array('label'=>'Create ChinchillaMarketTrade','url'=>array('create')),
	array('label'=>'Manage ChinchillaMarketTrade','url'=>array('admin')),
);
?>

<h1>Chinchilla Market Trades</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
