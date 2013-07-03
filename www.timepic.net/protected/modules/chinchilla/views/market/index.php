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
                <img class="tradeImage" src="http://test.timepic.net/images/upload/totorotalk/201302/mark/61b3f342ec1eb95a0101407cf9d87d26.jpg">
            </div>
            <div class="offset2 row-fluid detail">
                <p class=""><strong><?php echo CHtml::encode($item['title']);?></strong></p>
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