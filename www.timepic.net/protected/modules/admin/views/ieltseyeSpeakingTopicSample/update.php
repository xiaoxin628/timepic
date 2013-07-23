<?php
$this->breadcrumbs=array(
	'Ieltseye Speaking Topic Samples'=>array('index'),
	$model->sampleid=>array('view','id'=>$model->sampleid),
	'Update',
);

$this->menu=array(
	array('label'=>'List IeltseyeSpeakingTopicSample','url'=>array('index')),
	array('label'=>'Create IeltseyeSpeakingTopicSample','url'=>array('create')),
	array('label'=>'View IeltseyeSpeakingTopicSample','url'=>array('view','id'=>$model->sampleid)),
	array('label'=>'Manage IeltseyeSpeakingTopicSample','url'=>array('admin')),
);
?>

<h1>Update IeltseyeSpeakingTopicSample <?php echo $model->sampleid; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>