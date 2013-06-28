<?php
$this->breadcrumbs=array(
	'龙猫视频'=>array('admin'),
	'新建视频',
);

$this->menu=array(
	array('label'=>'管理','url'=>array('admin')),
    array('label'=>'新建','url'=>array('create'), 'active'=>true),

);

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));
?>

<h1>Create TotoroVideo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>