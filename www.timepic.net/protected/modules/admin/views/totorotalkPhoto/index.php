<?php
$this->breadcrumbs=array(
	'Totorotalk Photos',
);

$this->menu=array(
	array('label'=>'Create TotorotalkPhoto','url'=>array('create')),
	array('label'=>'Manage TotorotalkPhoto','url'=>array('admin')),
);
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));

?>

<h1>Totorotalk Photos</h1>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array('name'=>'Pid', 'value'=>'$data->pid'),
		'title',
		'imgtype',
		'size',
		'thumb',
		array('name'=>'filepath','type'=>'html', 'value'=>'CHtml::link(CHtml::image(CommonHelper::get_totorophoto(Yii::app()->params["site"]."/images/upload/totorotalk/".$data->filepath, "thumb"), $data->filename), CommonHelper::get_totorophoto(Yii::app()->params["site"]."/images/upload/totorotalk/".$data->filepath, "origin"), array("target"=>"_blank"))'),
//		array('name'=>'filepath', 'type' => 'html', 'value'=>'<a href="CommonHelper::get_totorophoto(Yii::app()->params["site"]."/images/upload/totorotalk/".$data->filepath, "origin")">aaaaa</a>'),
		'filename',
		array('name'=> 'dateline', 'value' => 'date("Y-m-d H:i:s", $data->dateline)'),
	),
)); ?>
