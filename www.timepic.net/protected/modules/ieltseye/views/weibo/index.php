<?php
$this->pageTitle = Yii::app()->params['ieltseye']['seoTitle']."-雅思口语考题实时回忆";
$this->breadcrumbs=array(
	'Topic',
);
?>
<?php if(!empty($keyword)):?>
<script type="text/javascript">
$(function () { 
    var count = 3;
    var countdown = setInterval(CountDown, 1000); 
    var btn = $("#topicSearch");
    function CountDown() {
        btn.attr("disabled", true); 
        btn.text("wait " + count + " s!"); 
        if (count == 0) { 
            btn.text("搜索").removeAttr("disabled"); 
            clearInterval(countdown); 
        } 
        count--; 
    }
})
</script> 
<?php endif;?>
<div class="row-fluid" style="margin-bottom: 10px;">
    
    <div class="span1">
        <button class="btn btn-primary pull-left" type="button" onclick="window.location.reload()">刷新</button>
    </div>
    <div class="span3">
        
        <?php $form=$this->beginWidget('CActiveForm',array(
            'id'=>'oralTopicSearch',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo CHtml::textField('keyword', CHtml::encode($keyword), array('class'=>'input-medium search-query')); ?>
        <?php 
        $htmlOptionsArr = !empty($keyword) ? array('id'=>'topicSearch','disabled'=>'true') : array('id'=>'topicSearch');
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'btn',
            'label'=>'搜索',
            'htmlOptions' =>$htmlOptionsArr,
        )); ?>

        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="row-fluid">
        <?php if(isset($data)): ?>
          <?php  foreach ($data as $item):?>
            <div class="row-fluid well well-small">
                <div class="row-fluid">
                    <a href="http://weibo.com/u/<?php echo $item['uid'];?>" target="_blank">
                        <?php echo CHtml::encode($item['screen_name']);?>
                    </a>
                </div>
                <div class="row-fluid">
                    <p>
                        <?php echo CHtml::encode($item['text']);?>
                    </p>
                    <p class="muted"><?php echo CHtml::encode(date("Y-m-d H:i:s", $item['created_at']))?></p>
                </div>
            </div>
          <?php endforeach;?>
        <?php else: ?>
            <div class="row-fluid well well-large">
                <div class="alert alert-error">
                  哦呦,貌似还木有微博，刷新试试...
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="pagination">
          <?php $this->widget('bootstrap.widgets.TbPager', 
              array('pages'=>$pages,
                  
                )
        );?>
</div>
