<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'ieltseye-speaking-topic-card-form-part2',
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnChange'=>true
    ),
)); ?>
    <h3>Part 2</h3>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownList($model, 'type', array('1'=>'Part 1', '2'=>'Part 2', '3'=>'Part 3') , array('class'=>'span5', 'onChange'=>'switchFrom(this.value)', 'options'=>array('2'=>array('selected'=>'selected')))); ?>
    <?php echo $form->textFieldRow($model,'tags',array('class'=>'span6','maxlength'=>255)); ?>
    
	<?php echo $form->textFieldRow($model,'question',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
    
    
    
    
    
    
<?php $form=$this->beginWidget('CActiveForm',array(
	'id'=>'ieltseye-speaking-topic-card-form-part13',
	'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
    'clientOptions' => array(
        'validateOnChange'=>true
    ),
    'htmlOptions'=>array('class'=>"hide"),
)); ?>
    <h3>Part 1 or 3</h3>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model, '' ,'', array('class'=>'alert alert-block alert-error')); ?>
    <?php echo $form->labelEx($model, 'type',array('class'=>'control-label'));?>
	<?php echo $form->dropDownList($model, 'type', array('1'=>'Part 1', '2'=>'Part 2', '3'=>'Part 3') , array('class'=>'span6', 'onChange'=>'switchFrom(this.value)')); ?>
    <?php echo $form->error($model,'type', array('class'=>'help-inline error')); ?>
    
    <?php echo $form->labelEx($model, 'tags',array('class'=>'control-label'));?>
    <?php echo $form->textField($model,'tags',array('class'=>'span6','maxlength'=>255)); ?>
    <?php echo $form->error($model,'tags', array('class'=>'help-inline error')); ?>
    <?php
        foreach($model->questions  as $key=>$question){
            echo CHtml::label('questions'.($key+1), '',array('class'=>'control-label'));
            echo CHtml::textField('IeltseyeSpeakingTopicCard[questions]['.$key.']', $question, array('class'=>'span8','maxlength'=>255));            
        }
    ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function switchFrom(id){
        typeId = id;
        if (id == '2') {
            $('#ieltseye-speaking-topic-card-form-part2').show();
            $('#ieltseye-speaking-topic-card-form-part13').hide();
        }else{
            $('#ieltseye-speaking-topic-card-form-part13').show();
            $('#ieltseye-speaking-topic-card-form-part2').hide();
        }
        $("select").val(typeId);
    }
    <?php if($model->type):?>
        var typeId = "<?php echo $model->type;?>";
        switchFrom(<?php echo $model->type;?>);
    <?php else:?>
        var typeId = "2";
    <?php endif;?>

</script>