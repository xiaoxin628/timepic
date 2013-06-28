<?php
$this->breadcrumbs=array(
	'Totorotalk百科'=>array('index'),
	'新建',
);

$this->menu=array(
	array('label'=>'全部','url'=>array('index')),
	array('label'=>'新建','url'=>array('create'), 'active'=> true),
	array('label'=>'管理','url'=>array('admin')),
);
 $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>$this->menu
));
?>

<h1>Create Totorotalk百科</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>