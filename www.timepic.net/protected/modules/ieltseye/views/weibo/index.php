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
        btn.text("wait " + count + "s!"); 
        if (count == 0) { 
            btn.text("Search").removeAttr("disabled"); 
            clearInterval(countdown); 
        } 
        count--; 
    }
})
</script> 
<?php endif;?>

<p id="back-to-top"><a href="#top">TOP</a></p>
<div class="row-fluid">
    
    <div class="span3 pull-left">
        
        <?php $form=$this->beginWidget('CActiveForm',array(
            'id'=>'oralTopicSearch',
            'enableAjaxValidation'=>false,
        )); ?>

        <?php echo CHtml::textField('keyword', CHtml::encode($keyword), array('class'=>'input-small search-query')); ?>
        <?php 
        $htmlOptionsArr = !empty($keyword) ? array('id'=>'topicSearch','disabled'=>'true') : array('id'=>'topicSearch');
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'btn',
            'label'=>'Search',
            'htmlOptions' =>$htmlOptionsArr,
        )); ?>
        <button class="btn btn-primary pull-right" type="button" onclick="window.location.reload()">Refresh</button>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="row-fluid">
        <?php if(isset($data)): ?>
          <?php  foreach ($data as $item):?>
            <div class="well well-small">
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
            <div class="well well-large">
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
<div class="gad">
    <?php $this->renderPartial('application.modules.ieltseye.views.public.gad');?>
</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42471034-1', 'ieltseye.com');
  ga('send', 'pageview');

</script>