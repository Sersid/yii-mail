<?php
/* @var $this TemplatesController */
/* @var $model CoreMailTemplate */
/* @var $form TbActiveForm */
Yii::app()->clientScript
	->registerScriptFile(CHtml::asset(__DIR__.'/../../assets/js/form.js'))
	->registerCssFile(CHtml::asset(__DIR__.'/../../assets/css/form.css'));
?>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'id' => 'template-form',
	'enableAjaxValidation' => false,
));
//new WhRedactor;
?>
<?php echo $form->errorSummary($model); ?>
<?php
echo $form->dropDownListControlGroup($model, 'event_id', CoreMailEvent::getEventsArray(), array(
	'class' => 'span5',
	'required' => 'required',
	//'displaySize' => 1,
	'data-manual-url' => $this->createUrl('/mail/events/manual'),
	'id' => 'template-events',
));
?>
<?php
echo $form->textFieldControlGroup($model, 'subject', array(
	'class' => 'span5',
	'maxlength' => 255,
));
?>
<?php
echo $form->textFieldControlGroup($model, 'from', array(
	'class' => 'span5',
	'maxlength' => 255,
	'required' => 'required',
));
?>
<?php
echo $form->textFieldControlGroup($model, 'to', array(
	'class' => 'span5',
	'maxlength' => 255,
	'required' => 'required',
	'placeholder' => 'Name Surname <user@example.ru>, user@example.ru',
));
?>
<div class="control-group">
	<div class="controls">
		<span class="pseudo" id="template-show-hidden">Показать дополнительные параметры</span>
	</div>
</div>
<?php
echo $form->textFieldControlGroup($model, 'сс', array(
	'class' => 'span5',
	'maxlength' => 255,
	'data-hidden' => 'true',
));
?>
<?php
echo $form->textFieldControlGroup($model, 'bss', array(
	'class' => 'span5',
	'maxlength' => 255,
	'data-hidden' => 'true',
));
?>
<?php
echo $form->textFieldControlGroup($model, 'reply_to', array(
	'class' => 'span3',
	'maxlength' => 100,
	'data-hidden' => 'true',
));
?>
<?php
echo $form->dropDownListControlGroup($model, 'priority', array('')+$model->getPriorities(), array(
	'class' => 'span2',
	'displaySize' => 1,
	'data-hidden' => 'true',
));
?>
<?php
echo $form->inlineRadioButtonListControlGroup($model, 'content_type', $model->getContentTypes(), array(
	'controlOptions' => array(
		'id' => 'template-radio-buttons',
	),
));
?>
<div class="control-group">
	<?php echo $form->label($model, 'body', array(
		'class' => 'control-label',
		'required' => $model->isAttributeRequired('body'),
		'for' => 'template-body-texarea',
	)) ?>
	<div class="controls">
		<?php $this->widget('yiiwheels.widgets.redactor.WhRedactor', array(
			'name' => $model->getAttributeInputName('body'),
			'id' => 'template-body-redactor',
			'value' => $model->body,
		));?>
		<?php echo $form->textArea($model, 'body', array(
			'class' => 'span7',
			'id' => 'template-body-textarea',
			'rows' => 3,
		));
		?>
		<div class="template-manual">
			#SITE_URL# - полный адрес сайта<br />
			#SITE_NAME# - название сайта<br />
			#SITE_EMAIL# - e-mail сайта
			<div id="template-ajax-manual"></div>
		</div>
	</div>
</div>
<?php echo $form->checkBoxControlGroup($model, 'state'); ?>
<?php
echo TbHtml::formActions(array(
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
));
?>
<?php $this->endWidget(); ?>