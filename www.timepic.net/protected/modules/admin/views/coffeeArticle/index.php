<?php
$this->breadcrumbs=array(
	'咖啡教程',
);

$this->menu=array(
	array('label'=>'全部','url'=>array('index'), 'active'=>true),
	array('label'=>'新建','url'=>array('create')),
	array('label'=>'管理','url'=>array('admin')),
);
 $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));

?>

<h1>咖啡教程</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'aid',
		'title',
		array('name'=>'content', 'value'=>'CommonHelper::cutstr($data->content, 300)'),
		array('name'=> 'dateline', 'value' => 'date("Y-m-d H:i:s", $data->dateline)'),
		array('name'=>'catid','value'=>'CoffeeArticle::getCategoryById($data->catid)'),
		'displayorder',
		'source',
	),
)); ?>
