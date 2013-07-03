<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ChinchillaMarketTrade','url'=>array('index')),
	array('label'=>'Create ChinchillaMarketTrade','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('chinchilla-market-trade-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('龙猫市场'=>array('index'), '我的龙猫交易'),
)); ?>
</div>
<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'龙猫市场', 'url'=>array('index')),
        array('label'=>'创建龙猫交易', 'url'=>array('create')),
        array('label'=>'我的龙猫交易', 'url'=>array('admin'), 'active'=>true),
    ),
    'htmlOptions'=>array('class'=> 'pull-right'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'chinchilla-market-trade-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'tradeId',
		'uid',
		'breed',
		'gender',
		'birthday',
		'weight',
		/*
		'ip',
		'description',
		'price',
		'pic',
		'dateline',
		'displayorder',
		*/
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
