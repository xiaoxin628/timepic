<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('龙猫市场'),
)); ?>
</div>
<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'龙猫市场', 'url'=>array('index'), 'active'=>true),
        array('label'=>'创建龙猫交易', 'url'=>array('create')),
        array('label'=>'我的龙猫交易', 'url'=>array('admin')),
    ),
    'htmlOptions'=>array('class'=> 'pull-right'),
)); ?>
</div>
<h1>Chinchilla Market Trades</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="row-fluid">
    <div class="row-fluid">
      <?php  foreach ($data as $item):?>
        <div class="row-fluid well well-large trade">
            <div class="span2">
                <a href="<?php echo $this->createUrl('view', array('id'=>$item['tradeId']))?>" target="_blank">
                    <img class="tradeImage" src="<?php echo CommonHelper::getImageByType($item['pic'], 'chinchillaMarket', 'thumb', 'url');?>">
                </a>
            </div>
            <div class="offset2 row-fluid detail">
                <p class=""><a href="<?php echo $this->createUrl('view', array('id'=>$item['tradeId']))?>" target="_blank"><strong><?php echo CHtml::encode($item['title']);?></strong></a></p>
                <p class="label label-info price">￥<?php echo CHtml::encode($item['price']);?></p>
                <p class="muted"><?php echo CHtml::encode($item['memberInfo']['username']); ?> - <?php echo CHtml::encode(date("Y-m-d H:i:s", $item['dateline'])); ?></p>
            </div>
        </div>
      <?php endforeach;?>
    </div>
</div>
<div class="pagination">
          <?php $this->widget('bootstrap.widgets.TbPager', 
              array('pages'=>$pages,
                  
                )
        );?>
</div>