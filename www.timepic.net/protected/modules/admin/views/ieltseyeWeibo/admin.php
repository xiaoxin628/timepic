<?php
$this->breadcrumbs=array(
	'Ieltseye Weibos'=>array('index'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List IeltseyeWeibo','url'=>array('index')),
//	array('label'=>'Create IeltseyeWeibo','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ieltseye-weibo-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Ieltseye Weibos</h1>

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
	'id'=>'ieltseye-weibo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'eid',
		'uid',
//		'uidstr',
		'wbid',
//		'wbmid',
		array('name'=>'text',
            'type'=>'html',
            'headerHtmlOptions'=>array('width'=>'40%'),
            'value'=>'"<p>".$data->text."</p>
                <p class=\"muted\">".$data->screen_name."--".date("Y/m/d H:i:s", $data->created_at)."</p>"',
            ),
		'keywords',
		array('name'=>'dateline','value'=>'date("Y-m-d H:i:s", $data->dateline)'),
		'status',
		'source',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
