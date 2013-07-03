<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('龙猫市场'=>array('index'), '修改龙猫交易 ID:'.$model->tradeId),
)); ?>
</div>
<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'龙猫市场', 'url'=>array('index')),
        array('label'=>'创建龙猫交易', 'url'=>array('create')),
        array('label'=>'我的龙猫交易', 'url'=>array('admin'), 'active'=>true),
    ),
    'htmlOptions'=>array('class'=> 'pull-right'),
)); ?>
</div>

<h1>Update ChinchillaMarketTrade <?php echo $model->tradeId; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model, 'tradeImages'=>$tradeImages)); ?>