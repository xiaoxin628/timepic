<?php
$this->breadcrumbs=array(
	'Msgboards',
);

$this->menu=array(
	array('label'=>'Create Msgboard','url'=>array('create')),
	array('label'=>'Manage Msgboard','url'=>array('admin')),
);
 $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));
?>

<h1>Msgboards</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
	'mid',
	'uid',
	'username',
	'email',
	array('name'=>'content', 'value'=>'CommonHelper::cutstr($data->content, 150)'),
	array('name'=>"dateline", 'value'=>'date("Y-m-d H:i:s", $data->dateline)'),
	'status',
	'appid',
	),
)); ?>
