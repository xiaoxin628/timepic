<?php
$this->breadcrumbs=array(
	'Totorotalk Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TotorotalkCategory','url'=>array('index')),
	array('label'=>'Manage TotorotalkCategory','url'=>array('admin')),
);
$this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));
?>

<h1>Create TotorotalkCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>