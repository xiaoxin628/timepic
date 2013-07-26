<?php
$this->pageTitle = Yii::app()->params['ieltseye']['seoTitle']."-Topic-口语卡-Tag";
$this->breadcrumbs=array(
	'IELTS Speaking Topic'=>array('/topic'),
    'Tag:'.$keyword,
);
?>
<div class="row-fluid">
        <?php if(!empty($dataProvider->data)): ?>
          <?php  foreach ($dataProvider->data as $item):?>
            <div class="topicCard">
                <div class="part"><?php echo "Part ".$item['type']?></div>
                <legend><?php echo str_ireplace($keyword, '<span class="alert alert-info ieltsKeyword">'.$keyword.'</span>', CHtml::encode($item['question']));;?></legend>
                <?php if($item['type'] == 2):?>
                    <p>You should say:</p>
                    <div class="description">
                        <?php echo TimePicCode::TpCode($item['description']);?>
                    </div>
                <?php endif;?>
                <?php if(isset($item['tags']) && !empty($item['tags'])):?>
                    <p>Tags: <?php echo IeltseyeHelper::formatTags($item['tags'], 1);?></p>
                <?php endif;?>
                <p><a class="btn btn-primary btn-small" href="<?php echo $this->createUrl("/sample/speakingTopic", array('id'=>$item['cardid']));?>">Samples</a></p>
            </div>
          <?php endforeach;?>
        <?php else: ?>
            <div class="well well-large">
                <div class="alert alert-error">
                  哦呦,貌似还木有这样的答题卡
                </div>
            </div>
        <?php endif; ?>
</div>
<div class="pagination">
          <?php $this->widget('application.components.widgets.TpPager', 
              array('pages'=>$dataProvider->pagination,
                    'maxButtonCount'=>'6',
                )
            );?>
</div>