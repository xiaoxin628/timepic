<?php 
        if($model->isNewRecord){
            $model->cardid = Yii::app()->request->getParam('id');
        }
        $card = IeltseyeSpeakingTopicCard::model()->findByPk($model->cardid);
?>

<div class="row-fluid">
    <div class="topicCard">
        <legend><?php echo $card->question?></legend>
        <?php if($card->type == 2):?>
            <p>You should say:</p>
            <div class="description">
                <?php echo TimePicCode::TpCode($card->description);?>
            </div>
        <?php endif;?>
    </div>
</div>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ieltseye-speaking-topic-sample-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textAreaRow($model,'content',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'author',array('class'=>'span5','maxlength'=>30)); ?>
    
    <?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textAreaRow($model,'source',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'displayorder',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cardid',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
