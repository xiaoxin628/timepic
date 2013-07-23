<?php
$this->breadcrumbs=array(
	'Ieltseye Speaking Topic Samples'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List IeltseyeSpeakingTopicSample','url'=>array('index')),
	array('label'=>'Manage IeltseyeSpeakingTopicSample','url'=>array('admin')),
);
?>

<h1>Create IeltseyeSpeakingTopicSample</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>