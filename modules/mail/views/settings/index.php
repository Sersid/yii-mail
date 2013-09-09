<?php
Yii::app()->clientScript->registerScriptFile(CHtml::asset(__DIR__.'/../../assets/js/setting.js'));

$this->pageTitle = 'Настройки';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Настройки',
);
$this->menu = array(
	array('label' => 'Шаблоны писем', 'url' => array('/mail')),
	array('label' => 'Типы почтовых событий', 'url' => array('/mail/events')),
	array('label' => 'Настройки', 'url' => array('/mail/settings'), 'active' => true),
);
?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo TbHtml::alert(TbHtml::ALERT_COLOR_SUCCESS, Yii::app()->user->getFlash('success'));
?>
<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id'=>'mail-settings-form',
	'enableAjaxValidation'=>false,
)); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset>
	<legend>Основные настройки</legend>
	<?php echo $form->textFieldControlGroup($model,'siteName',array(
		'class'=>'span3',
		'required' => 'required',
	)); ?>
	<?php echo $form->emailFieldControlGroup($model,'siteEmail',array(
		'class'=>'span3',
		'required' => 'required',
	)); ?>
	<?php echo $form->urlFieldControlGroup($model,'siteUrl',array(
		'class'=>'span3',
		'required' => 'required',
	)); ?>
</fieldset>
<fieldset>
	<legend>Настройка отправки писем</legend>
	<?php echo $form->inlineRadioButtonListControlGroup($model, 'transportType',$model->getTransportTypes(), array(
		'controlOptions' => array(
		'id' => 'settings-radio-buttons',
	),
	)); ?>
	<?php echo $form->textFieldControlGroup($model,'smptHost',array(
		'class'=>'span3',
		'data-hidden' => true,
	)); ?>
	<?php echo $form->textFieldControlGroup($model,'smptPort',array(
		'class'=>'span1',
		'data-hidden' => true,
	)); ?>
	<?php echo $form->textFieldControlGroup($model,'smptUsername',array(
		'class'=>'span3',
		'data-hidden' => true,
	)); ?>
	<?php echo $form->passwordFieldControlGroup($model,'smptPassword',array(
		'class'=>'span3',
		'data-hidden' => true,
	)); ?>
</fieldset>
<?php echo TbHtml::formActions(array(
    TbHtml::submitButton('Сохранить', array(
		'color' => TbHtml::BUTTON_COLOR_PRIMARY,
		'icon' => 'ok',
		'size' => 'large',
	)),
)); ?>
<?php $this->endWidget(); ?>