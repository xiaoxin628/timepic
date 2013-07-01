<?php $form=$this->beginWidget('CActiveForm',array(
	'id'=>'chinchilla-market-trade-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'focus'=>array($model,'breed'),
	'htmlOptions'=>array('class'=>'form-horizontal'),
	'clientOptions'=>array('validateOnSubmit'=>true,
							'afterValidate' => 'js:checkChinchillaGVC',
		)

)); ?>
	<div class="alert alert-info" id="chinchillaNotice">
	  <button type="button" class="close" data-dismiss="alert">&times;</button>
	  <h4>提示</h4>
	  如果颜色选项中没有您要描述的龙猫颜色，请点击高级模式进行选择。
	</div>

	<div class="control-group" >
		<div class="span4" id="classicColorChoosing" >
			<div class="control-group">
				<?php echo CHtml::link('高级模式', '#', array('class'=>'btn btn-primary offset1 span1', 'onclick'=>"ChangeMenu('advanced');")) ?>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('颜色<span class="required">*</span>', 'ChinchillaMarketTrade_Gene_classic',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[classic]', '600000', array(600000=>'标灰',
																			 600100=>'纯白或银白',
																			 630000=>'深黑'
																			),
																		array('class'=>'input-small','onchange'=>"UpdateChinchillaImage('Chinchilla');")
																			); ?>
				</div>
			</div>			
		</div>
		<div class="span4" id="advancedColorChoosing" style="display:none;">
			<div class="control-group">
				<?php echo CHtml::link('经典模式', '#', array('class'=>'btn btn-primary offset1 span1', 'onclick'=>"ChangeMenu('classic');")) ?>
			</div>

			<div class="control-group">
				<?php echo CHtml::label(Yii::t('Base','Beige'), 'ChinchillaMarketTrade_Gene_id1',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[Gene_id1]', '0', array(0=>Yii::t('Base', 'No Beige'),
																			 1=>Yii::t('Base', 'Hetero-Beige'),
																			 2=>Yii::t('Base', 'Homo-Beige')
																			),
																		array('class'=>'input-small','onchange'=>"UpdateParentImage('Chinchilla');")
																			); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label(Yii::t('Base','White'), 'ChinchillaMarketTrade_Gene_id2',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[Gene_id2]', '0', array(0=>Yii::t('Base', 'No White'),
																								 1=>Yii::t('Base', 'White')
																								),
																							array('class'=>'input-small','onchange'=>"UpdateParentImage('Chinchilla');")
																							); ?>
				</div>
			</div>
			<div class="control-group">

				<?php echo CHtml::label(Yii::t('Base','Velvet'), 'ChinchillaMarketTrade_Gene_id3',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[Gene_id3]', '0', array(0=>Yii::t('Base', 'No Velvet or TOV'),
																								 1=>Yii::t('Base', 'Velvet or TOV')
																								),
																							array('class'=>'input-small','onchange'=>"UpdateParentImage('Chinchilla');")
																							); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label(Yii::t('Base','Ebony'), 'ChinchillaMarketTrade_Gene_id4',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[Gene_id4]', '0', array(0=>Yii::t('Base', 'No Ebony'),
																								 1=>Yii::t('Base', 'Light Ebony (or Carrier)'),
																								 2=>Yii::t('Base', 'Medium Ebony'),
																								 3=>Yii::t('Base', 'Dark Ebony'), 
																								 4=>Yii::t('Base', 'Extra Dark Ebony (Homo)')
																								),
																							array('class'=>'input-small','onchange'=>"UpdateParentImage('Chinchilla');")
																							); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label(Yii::t('Base','Vio/Sap'), 'ChinchillaMarketTrade_Gene_id5',array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('ChinchillaMarketTrade[Gene_id5]', '6', array(6=>Yii::t('Base', 'No Recessive'),
																								 3=>Yii::t('Base', 'Violet'),
																								 1=>Yii::t('Base', 'Sapphire'),
																								 5=>Yii::t('Base', 'Violet-Carrier'),
																								 4=>Yii::t('Base', 'Sapphire-Carrier'),
																								),
																							array('class'=>'input-small','onchange'=>"UpdateParentImage('Chinchilla');")
																							); ?>

					<?php echo $form->error($model,'breed', array('class'=>'help-inline error')); ?>
				</div>
			</div>


		</div>
		<div class="span2">
			<Legend>
				
				<div class="row-fluid">
					<div class="icon-home"> </div>
					<img id="ChinchillaImage" class="img-circle"  src="<?php echo Yii::app()->request->getBaseUrl(true); ?>/images/static/totorocross/600000.jpg" alt="Chinchilla Sire Phenotype" />
				</div>
				<?php echo CHtml::label(' ', 'ChinchillaImage',array('id'=>'chinchillaColor','class'=>'label-info label block')) ;?>
			</Legend>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'gender', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->radioButtonList($model,'gender',array('0'=>'DD', '1'=>'MM'), array('labelOptions'=>array('separator'=>' ','class'=>'radio inline'))); ?>
			<?php echo $form->error($model,'gender', array('class'=>'help-inline error')); ?>
		</div>

	</div>

    
	<div class="control-group">
		<?php echo $form->labelEx($model,'birthday', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->dateField($model,'birthday',array('class'=>'input-medium')); ?>
			<?php echo $form->error($model,'birthday', array('class'=>'help-inline error')); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'expiredDate', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->dateField($model,'expiredDate',array('class'=>'input-medium')); ?>
			<?php echo $form->error($model,'expiredDate', array('class'=>'help-inline error')); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'weight', array('class'=>'control-label')); ?>
		<div class="controls ">
			<div class="input-append">
				<?php echo $form->numberField($model,'weight',array('class'=>'input-small')); ?>
				<span class="add-on">g</span>
			</div>	
			<?php echo $form->error($model,'weight', array('class'=>'help-inline error')); ?>
		</div>
	</div>


	<div class="control-group">
		<?php echo $form->labelEx($model,'price', array('class'=>'control-label')); ?>
		<div class="controls">
			<div class="input-prepend input-append">
				<span class="add-on">￥</span>
					<?php echo $form->numberField($model,'price',array('class'=>'input-small')); ?>
				<span class="add-on">RMB</span>
			</div>
				<?php echo $form->error($model,'price', array('class'=>'help-inline error')); ?>
		</div>
	</div>


	<div class="control-group">
		<?php echo $form->labelEx($model,'pic', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'pic',array('class'=>'input-small','maxlength'=>150)); ?>
			<?php echo $form->error($model,'pic', array('class'=>'help-inline error')); ?>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'title', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textField($model,'title',array('class'=>'span5','maxlength'=>60)); ?>
			<div class="row-fluid">
				<?php echo $form->error($model,'title', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>

	<div class="control-group">
		<?php echo $form->labelEx($model,'description', array('class'=>'control-label')); ?>
		<div class="controls">
			<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span5')); ?>
			<div class="row-fluid">
				<?php echo $form->error($model,'description', array('class'=>'help-inline error')); ?>
			</div>
		</div>
	</div>
	<input type="hidden" value="0" id="ChinchillaGVC" name="ChinchillaGVC" />


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		 )); ?>
	</div>

<?php $this->endWidget(); ?>
<script language="javascript">
	function checkChinchillaGVC(){
		if ($("#ChinchillaGVC").val() == 0) {
			alert('颜色选择异常，建议保存数据，重新刷新该页面！');
			return false;
		};	
		return true;
	}
	function ChangeMenu(menu){
		advancedMenu = $('#advancedColorChoosing');
		classicMenu = $('#classicColorChoosing');
		if (menu == 'classic') {
			advancedMenu.hide('normal');
			classicMenu.show('normal');
			UpdateChinchillaImage('Chinchilla');
		}else{
			classicMenu.hide('normal');
			advancedMenu.show('normal');
			UpdateParentImage("Chinchilla");
		};
		
	}
	
	function UpdateChinchillaImage(Parent) {
		var GenotypeValueCode;
		GenotypeValueCode = $('#ChinchillaMarketTrade_classic').val();
		var Imgid = "#"+Parent+"Image";
		var src = $(Imgid).src = "<?php echo Yii::app()->request->getBaseUrl(true); ?>/images/static/totorocross/" + GenotypeValueCode + ".jpg";
		$(Imgid).hide('fast',function(){$(Imgid).attr('src', src);});
		$(Imgid).show('fast');
		CalcGenotype(GenotypeValueCode);
	}

	function UpdateParentImage(Parent) {
		var GenotypeValueCode;
		GenotypeValueCode = CompileGenotypeValueCode('ChinchillaMarketTrade_');
		var Imgid = "#"+Parent+"Image";
		var src = $(Imgid).src = "<?php echo Yii::app()->request->getBaseUrl(true); ?>/images/static/totorocross/" + GenotypeValueCode + ".jpg";
		$(Imgid).hide('fast',function(){$(Imgid).attr('src', src);});
		$(Imgid).show('fast');
		// $(Imgid).attr('src', src);
	}

	function CompileGenotypeValueCode(Parent) {
		var x,el,Gene_id;
		var GenotypeValueCode=0;
		for (x=0;x<$("select").length;x++) {
			el=$("select")[x];
			// ChinchillaMarketTrade[Gene_id3]
			if (el.id.substr(0,Parent.length + 7)==(Parent+ "Gene_id")) {
				Gene_id=el.name.substr(Parent.length + 7);
				GenotypeValueCode += Math.pow(10,parseInt(Gene_id)) * el.value;
			}
		}
		CalcGenotype(GenotypeValueCode);
		return(GenotypeValueCode);
	}

	function CalcGenotype(GenotypeValueCode) {
		$("#ChinchillaGVC").val(GenotypeValueCode);
		colorObject=$.ajax({url:"<?php echo Yii::app()->request->getBaseUrl(true);?>/chinchilla/market/getChinchillaColor/imageid/"+GenotypeValueCode,async:false});
  			$("#chinchillaColor").html(colorObject.responseText);
	}
	//Update the images using a script, so that browsers which don't support script, show the unknown image. UpdateParentImage("Sire");
	UpdateChinchillaImage('Chinchilla');
	</script>
