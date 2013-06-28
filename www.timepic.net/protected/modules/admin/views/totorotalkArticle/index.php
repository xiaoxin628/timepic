<?php
$this->breadcrumbs=array(
	'Totorotalk百科',
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

<h1>Totorotalk百科</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
	'columns'=>array(
		'aid',
		'title',
		array('name'=>'content', 'value'=>'CommonHelper::cutstr($data->content, 300)'),
		'views',
		array('name'=> 'dateline', 'value' => 'date("Y-m-d H:i:s", $data->dateline)'),
		array('name'=>'catid','value'=>  'TotorotalkCategory::getTotoroCategory($data->catid)'),
		'displayorder',
	),
)); ?>
