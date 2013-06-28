<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'totorotalk-photo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'ip',array('class'=>'span5','maxlength'=>20)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'imgtype',array('class'=>'span5','maxlength'=>40)); ?>

	<?php echo $form->textFieldRow($model,'size',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'thumb',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'filepath',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'filename',array('class'=>'span5','maxlength'=>30)); ?>

	<?php echo $form->textFieldRow($model,'dateline',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
