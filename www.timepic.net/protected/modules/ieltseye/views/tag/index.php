<?php
$this->pageTitle = Yii::app()->params['ieltseye']['seoTitle']."-Tag-口语卡分类";
$this->breadcrumbs=array(
	'IELTS Speaking Tag'=>array('/tag'),
);
?>
<div class="row-fluid">
    <script type="text/javascript">
        var tags = <?php echo json_encode($tagsData);?>;
        function searchTag(){
            tagid = tags[$('#searchTag').val()];
            if (!tagid) {
                alert("Sorry, cannot find this tag.");
                return false;
            }else{
                window.location.href = "/topic/tag/"+tagid;
            }
        }
    </script>
    <p>
        <?php
            $this->widget('bootstrap.widgets.TbTypeahead', array(
                'name'=>'typeahead',
                'options'=>array(
                    'source'=>$typeAheadData,
                    'items'=>4,
                    'matcher'=>"js:function(item) {
                        return ~item.toLowerCase().indexOf(this.query.toLowerCase());
                    }",
                ),
                'htmlOptions'=>array('id'=>"searchTag"),
            ));
        ?>
        <button type="button" class="btn btn-primary" style="margin-bottom: 10px;" onclick="searchTag();">Search</button>
    </p>
</div>
<div class="row-fluid">
    <div class="row-fluid">
        <?php if(isset($tagsData)): ?>
          <?php  foreach ($tagsData as $tagname=>$tagid):?>
                <div class="span2" style="margin-left: 0px;">
                    <a  target="_blank" href="<?php echo Yii::app()->createUrl('/topic/tag/',array('id'=>$tagid));?>"  title="IELTS Tag:<?php echo $tagname;?>">
                        <?php echo $tagname;?>
                    </a>
                </div>
          <?php endforeach;?>
        <?php else: ?>
            <div class="well well-large">
                <div class="alert alert-error">
                  哦呦,貌似还木有这样的Tag
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>