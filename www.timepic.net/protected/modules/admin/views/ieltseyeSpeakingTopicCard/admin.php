<?php
$this->breadcrumbs=array(
	'Ieltseye Speaking Topic Cards'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List','url'=>array('index')),
	array('label'=>'Create','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ieltseye-speaking-topic-card-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ieltseye Speaking Topic Cards</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'ieltseye-speaking-topic-card-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'cardid',
        array('name' => 'question',
            'type'=>'html',
            'headerHtmlOptions'=>array('width'=>'50%'),
            'value' => '"<h4>".$data->question."</h4><p class=\"muted\">".TimePicCode::TpCode($data->description)."<br />Tags: ".IeltseyeHelper::formatTags($data->tags, 1)."</p>"'),
		array('name' => 'type',  'headerHtmlOptions'=>array('width'=>'10%'), 'value' => '"Part ".$data->type'),
        array('name' => 'dateline', 'value' => 'date("Y-m-d H:i:s", $data->dateline)'),
		array(
            'header'=>'操作',
            'headerHtmlOptions'=>array('width'=>'10%'),
			'class'=>'bootstrap.widgets.TbButtonColumn',
            'template'=>'{samples}{createSample}{view}{update}{delete}',
            'buttons'=>array(
                'samples' => array(
                    'label'=>'<i class="icon-th-list"></i>',
                    'options'=>array('title'=>'例文'),
                    'url' => 'Yii::app()->createUrl("admin/ieltseyeSpeakingTopicSample/admin",array("id"=>"$data->cardid"))',
                ),
                'createSample' => array(
                    'label'=>'<i class="icon-plus"></i>',
                    'options'=>array('title'=>'创建例文'),
                    'url' => 'Yii::app()->createUrl("admin/ieltseyeSpeakingTopicSample/create",array("id"=>"$data->cardid"))',
                ),
            ),
		),
	),
)); ?>
