<?php
$this->pageTitle = Yii::app()->params['ieltseye']['seoTitle']."-Topic-口语卡-Part3";
$this->breadcrumbs=array(
	'IELTS Speaking Topic'=>array('/topic'),
    'Part 3',
);
?>
<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Part1', 'url'=>array('/topic/part1')),
        array('label'=>'Part2', 'url'=>array('/topic/part2')),
        array('label'=>'Part3', 'url'=>array('/topic/part3'),'active'=>true),
    ),
)); ?>
</div>
<p id="back-to-top"><a href="#top">TOP</a></p>
<?php $this->renderpartial('_cardItem', array('dataProvider'=>$dataProvider, 'keyword'=>$keyword));?>