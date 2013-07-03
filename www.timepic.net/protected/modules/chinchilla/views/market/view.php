
<div class="row-fluid">
<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
    'links'=>array('龙猫市场'=>array('index'), CommonHelper::cutstr($model->title, 30)),
)); ?>
</div>
<div class="row-fluid">
    <?php $this->widget('bootstrap.widgets.TbMenu', array(
    'type'=>'pills', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'龙猫市场', 'url'=>array('index'),'active'=>true),
        array('label'=>'创建龙猫交易', 'url'=>array('create')),
        array('label'=>'我的龙猫交易', 'url'=>array('admin')),
    ),
    'htmlOptions'=>array('class'=> 'pull-right'),
)); ?>
</div>
<p class='text-left muted'>发表时间：<?php echo CHtml::encode(date("Y-m-d H:i:s", $model->dateline)); ?></p>
<div class="row-fluid">
    <div class="row-fluid span7">
        <h3><?php echo CHtml::encode($model->title);?></h3>
        <div class="row-fluid">
            <div class="span4">
                <img class='img-polaroid' src="<?php echo CommonHelper::getImageByType($model->pic, 'chinchillaMarket', 'normal', 'url') ?>" />
            </div>
            <div class="span5">
                <dl class="dl-horizontal">
                    <dt><span class="label label-success">毛色</span></dt>
                    <dd>
                        <span class="badge badge-info">
                        <?php echo CHtml::encode($model->getChinchillaColor($model->breed)); ?>
                        </span>
                    </dd>
                    <dt><span class="label label-success">性别</span></dt>
                    <dd><span class="badge badge-info"><?php echo CHtml::encode($model->gender ? 'DD' : 'MM'); ?></span></dd>
                    <dt><span class="label label-success">体重</span></dt>
                    <dd><span class="badge badge-info"><?php echo CHtml::encode($model->weight); ?>g</span></dd>
                    <dt><span class="label label-success">价格</span></dt>
                    <dd><span class="badge badge-info">￥<?php echo CHtml::encode($model->price); ?></span></dd>
                    <dt><span class="label label-success">出生日期</span></dt>
                    <dd><span class="badge badge-info"><?php echo CHtml::encode(date("Y-m-d", $model->birthday)); ?></span></dd>
                    <dt><span class="label label-important">交易过期时间</span></dt>
                    <dd><span class="badge badge-info"><?php echo CHtml::encode(date("Y-m-d", $model->expiredDate)); ?></span></dd>
                </dl>
            </div>
            <div class="span2 pull-right">
                <img class='img-circle' src='<?php echo Yii::app()->request->getBaseUrl(true)."/images/static/totorocross/".$model->breed.".jpg"; ?>'>
            </div>
        </div>
        <div class='row-fluid'> &nbsp;</div>
        <div class="row-fluid ">
            <p class='label label-info'>相关图片</p>
            <ul class="thumbnails">
                <?php if (isset($tradeImages)): ?>
                    <?php foreach ($tradeImages as $key => $image): ?>
                        <li class="span3">
                            <div class="thumbnail">
                                <a class='lightbox' href="<?php echo CommonHelper::getImageByType($image->filepath, "chinchillaMarket", "big", 'url',1); ?>">
                                    <img src="<?php echo CommonHelper::getImageByType($image->filepath, "chinchillaMarket", "normal", 'url'); ?>" />
                                </a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="row-fluid well">
            <blockquote class="text-info">
                <?php echo TimePicCode::TpCode($model->description); ?>
            </blockquote>
        </div>
    </div>
    <div class="row-fluid span4 pull-right well">
        asdfasdfasdfasf
    </div>
</div>
<script type="text/javascript">
$(function() {
	$('a.lightbox').lightBox();
});
</script>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/jquery.lightbox.js");?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl."/css/lightbox.css");?>
<?php
Yii::app()->clientScript->registerScript('admin_lightbox',"$('a.lightbox').lightBox();", CClientScript::POS_READY);
?>
