<?php
$this->breadcrumbs=array(
	'Ieltseye Speaking Topic Cards'=>array('index'),
	$model->cardid=>array('view','id'=>$model->cardid),
	'Update',
);

$this->menu=array(
	array('label'=>'List IeltseyeSpeakingTopicCard','url'=>array('index')),
	array('label'=>'Create IeltseyeSpeakingTopicCard','url'=>array('create')),
	array('label'=>'View IeltseyeSpeakingTopicCard','url'=>array('view','id'=>$model->cardid)),
	array('label'=>'Manage IeltseyeSpeakingTopicCard','url'=>array('admin')),
);
?>

<h1>Update IeltseyeSpeakingTopicCard <?php echo $model->cardid; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>