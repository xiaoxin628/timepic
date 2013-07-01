<?php
$this->breadcrumbs=array(
	'Chinchilla Market Trades',
);

// $this->menu=array(
// 	array('label'=>'Create ChinchillaMarketTrade','url'=>array('create')),
// 	array('label'=>'Manage ChinchillaMarketTrade','url'=>array('admin')),
// );
?>

<h1>Chinchilla Market Trades</h1>
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