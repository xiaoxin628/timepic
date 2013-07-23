<?php
$this->pageTitle = Yii::app()->params['ieltseye']['seoTitle']."-雅思口语考题实时回忆";
//$this->breadcrumbs=array(
//	'Topic',
//);
?>
<?php if(!empty($keyword)):?>
<script type="text/javascript">
$(function () { 
    var count = 3;
    var countdown = setInterval(CountDown, 1000); 
    var btn = $("[name='topicSearch']");
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
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>友情提醒!</strong> 
  <p>雅思口语回忆，请新浪微博<?php echo CHtml::link('@雅思口语网蹲哥', Yii::app()->params['ieltseye']['adminWeibo'])?></p>
  <p>下载：<?php echo CHtml::link('Android', 'http://shouji.360tpcdn.com/360sj/dev/20130723/com.ieltseye.IELTSEye_1_114851.apk')?>版 
    <!--下载按钮开始-->
    <a title="使用360手机助手安装" href="zhushou360://type=apk&name=雅思口语网蹲哥&icon=http://p2.qhimg.com/t01a746d814c3a53a4c.png&url=http://shouji.360tpcdn.com/360sj/dev/20130723/com.ieltseye.IELTSEye_1_114851.apk"><img alt="使用360手机助手安装" src="http://p3.qhimg.com/t01943097a6b50d1e96.png"></a>
    <!--下载按钮结束-->
    <!--请把这段代码放在页面最底部加载-->
    <script src="http://zhushou.360.cn/script/360mobilemgrdownload.js"></script>
    <!--代码结束-->
  </p>
</div>
<p id="back-to-top"><a href="#top">TOP</a></p>
<div class="row-fluid">
    
    <div class="span4">
        <?php $form=$this->beginWidget('CActiveForm',array(
            'id'=>'oralTopicSearch',
            'enableAjaxValidation'=>false,
            'method'=>'get',
        )); ?>

        <?php echo CHtml::textField('keyword', CHtml::encode($keyword), array('class'=>'input-small search-query')); ?>
        <?php 
        $htmlOptionsArr = !empty($keyword) ? array('name'=>'topicSearch','disabled'=>'true') : array('name'=>'topicSearch');
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'btn',
            'label'=>'Search',
            'htmlOptions' =>$htmlOptionsArr,
        )); ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->params['ieltseye']['homeUrl'];?>">Refresh</a>
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
                        <?php echo $item['text'];?>
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
<div class="row-fluid">
    
    <div class="span4">
        <?php $form=$this->beginWidget('CActiveForm',array(
            'id'=>'oralTopicSearch',
            'enableAjaxValidation'=>false,
            'method'=>'get',
        )); ?>

        <?php echo CHtml::textField('keyword', CHtml::encode($keyword), array('class'=>'input-small search-query')); ?>
        <?php 
        $htmlOptionsArr = !empty($keyword) ? array('name'=>'topicSearch','disabled'=>'true') : array('name'=>'topicSearch');
        $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'btn',
            'label'=>'Search',
            'htmlOptions' =>$htmlOptionsArr,
        )); ?>
        <a class="btn btn-primary" href="<?php echo Yii::app()->params['ieltseye']['homeUrl'];?>">Refresh</a>
        <?php $this->endWidget(); ?>
    </div>
</div>
<div class="pagination">
          <?php $this->widget('application.components.widgets.TpPager', 
              array('pages'=>$pages,
                    'maxButtonCount'=>'6',
                )
        );?>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42471034-1', 'ieltseye.com');
  ga('send', 'pageview');

</script>