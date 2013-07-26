<?php
$this->pageTitle .= "-".CHtml::encode($topicCard->question);
$this->breadcrumbs=array(
	'IELTS Speaking Topic'=>$this->createUrl("/topic"),
    CHtml::encode($topicCard->question)
);
?>
<div class="row-fluid">
    <div class="span7 pull-left">
        <div>
            <div class="topicCard">
                <div class="part"><?php echo "Part ".$topicCard->type;?></div>
                <legend><?php echo CHtml::encode($topicCard->question);?></legend>
                <?php if ($topicCard->type == 2): ?>
                    <p>You should say:</p>
                    <div class="description">
                        <?php echo TimePicCode::TpCode(CHtml::encode($topicCard->description)); ?>
                    </div>
                <?php endif; ?>
                <p><a class="btn btn-primary btn-small" href="#sampleFormModal" data-toggle="modal">答题</a></p>
                <div id="sampleFormModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
            </div>
        </div>
        <div>
        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'ieltseyeSpeakingTopic-grid',
            'dataProvider'=>$dataprovider,
            'columns'=>array(
                array('name'=>'content',
                    'type'=>'html',
                    'header'=>'Samples',
                    'headerHtmlOptions'=>array('width'=>'100%'),
                    'value'=>'"<a href=\"".Yii::app()->createUrl("sample/speakingView/", array("id"=>$data->sampleid))."\">
                               <p class=\"muted\">
                                        ".CommonHelper::cutstr(TimePicCode::TpCode($data->content), 400)."
                               </p></a>
                               <p class=\"muted\">".date("Y-m-d H:i:s", $data->dateline)."</p>

                               "' 
                    ),
            ),
        )); ?>
        </div>
    </div>
    <div class="span4 pull-right well">
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

<script type="text/javascript">
$('#sampleFormModal').on('show', function () {
    $.get('/sample/create/'+"<?php echo $topicCard->cardid;?>", function(data) {
        $("#sampleFormModal").html(data);
    });
})
</script>