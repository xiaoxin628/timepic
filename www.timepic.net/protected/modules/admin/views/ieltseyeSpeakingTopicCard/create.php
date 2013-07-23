<?php
$this->breadcrumbs=array(
	'Ieltseye Speaking Topic Cards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List IeltseyeSpeakingTopicCard','url'=>array('index')),
	array('label'=>'Manage IeltseyeSpeakingTopicCard','url'=>array('admin')),
);
?>

<h1>Create IeltseyeSpeakingTopicCard</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>