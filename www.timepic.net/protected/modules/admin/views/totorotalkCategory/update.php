<?php
$this->breadcrumbs=array(
	'Totorotalk Categories'=>array('index'),
	$model->catid=>array('view','id'=>$model->catid),
	'Update',
);

$this->menu=array(
	array('label'=>'List TotorotalkCategory','url'=>array('index')),
	array('label'=>'Create TotorotalkCategory','url'=>array('create')),
	array('label'=>'View TotorotalkCategory','url'=>array('view','id'=>$model->catid)),
	array('label'=>'Manage TotorotalkCategory','url'=>array('admin')),
);
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));
?>

<h1>Update TotorotalkCategory <?php echo $model->catid; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>