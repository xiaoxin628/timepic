<?php
$this->pageTitle .= "-".CHtml::encode($sample->topicCard->question);
$this->breadcrumbs=array(
	'IELTS Speaking Topic Sample'=>$this->createUrl("sample/speakingTopic/", array("id"=>$sample->topicCard->cardid)),
    CHtml::encode(CommonHelper::cutstr($sample->content, 50))
);
?>
<div class="row-fluid">
    <div class="topicCard">
        <div class="part"><?php echo "Part ".$sample->topicCard->type;?></div>
        <legend><?php echo CHtml::encode($sample->topicCard->question);?></legend>
        <?php if ($sample->topicCard->type == 2): ?>
            <p>You should say:</p>
            <div class="description">
                <?php echo TimePicCode::TpCode(CHtml::encode($sample->topicCard->description)); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="row-fluid">
    <blockquote class="well-small sample">
    <?php echo TimePicCode::TpCode(CHtml::encode($sample->content));?>
    <small><?php echo $sample->author ? $sample->author : 'anonymous';?>  <cite title="<?php echo date("Y/m/d H:i:s", $sample->dateline);?>"><?php echo date("Y/m/d H:i:s", $sample->dateline);?></cite></small>
    </blockquote>
</div>
<div class="row-fluid show_nave">
    <div class="well well-small">
        <script type="text/javascript">
            (function(){
                var url = "http://widget.weibo.com/distribution/comments.php?width=0&url=auto&color=cccccc,ffffff,4c4c4c,5093d5,cccccc,f0f0f0&colordiy=1&ralateuid=3594633532&appkey=3706708774&dpc=1";
                url = url.replace("url=auto", "url=" + document.URL); 
                document.write('<iframe id="WBCommentFrame" src="' + url + '" scrolling="no" frameborder="0" style="width:100%"></iframe>');
            })();
        </script>
        <script src="http://tjs.sjs.sinajs.cn/open/widget/js/widget/comment.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
            window.WBComment.init({
                "id": "WBCommentFrame"
            });
        </script>
    </div>
</div>
