<?php
/* @var $this EvenvController */
/* @var $model CoreMailEvent */
/* @var $form CActiveForm */
?>
<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'core-mail-event-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldControlGroup($model,'code',array(
	'class'=>'span3',
	'required' => 'required',
	'pattern' => '^[A-Z\_\-0-9]{2,100}$',
	'maxlength'=>100,
)); ?>
<?php echo $form->textFieldControlGroup($model,'name',array(
	'class'=>'span3',
	'required' => 'required',
	'maxlength'=>100,
)); ?>
<?php echo $form->textAreaControlGroup($model,'desc',array(
	'rows'=>6,
	'class'=>'span6',
)); ?>
<?php echo $form->checkBoxControlGroup($model,'state'); ?>
<?php echo TbHtml::formActions(array(
    TbHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array(
		'color' => TbHtml::BUTTON_COLOR_PRIMARY,
		'icon' => 'ok',
		'size' => 'large',
	)),
	TbHtml::linkButton('Отмена', array(
		'icon' => 'remove',
		'size' => 'small',
		'url' => $model->isNewRecord ? array('index') : array('view', 'id' => $model->id),
	)),
)); ?>
<?php $this->endWidget(); ?>