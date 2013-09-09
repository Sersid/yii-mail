<?php
/* @var $this TemplatesController */
/* @var $model CoreMailTemplate */
$this->pageTitle = 'Шаблон #'.$model->id;
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Шаблоны писем' => array("index"),
	'Шаблон #'.$model->id,
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить шаблон', 'url' => array('create')),
);
$this->leftMenu = array(
	array('label' => 'Редактировать', 'url' => array('update','id'=>$model->id)),
	array(
		'label' => 'Удалить',
		'url' => array('delete','id'=>$model->id),
		'linkOptions'=>array(
			'submit'=>array('delete','id'=>$model->id),
			'confirm'=>'Вы уверены, что хотите удалить данный шаблон?',
		),
	),
);
?>
<?php $this->widget('backend.widgets.SersDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name' => 'event_id',
			'value' => CHtml::link(CoreMailEvent::getEventName($model->event_id), array("/mail/events/view", "id" => $model->event_id)),
			'type' => 'raw',
		),
		'subject',
		'from',
		'to',
		/*'сс',*/
		'bss',
		'reply_to',
		array(
			'name' => 'priority',
			'value' => $model->getPriority(),
		),
		array(
			'name' => 'content_type',
			'value' => $model->getContentType(),
		),
		array(
			'name' => 'body',
			'value' => nl2br($model->body),
			'type' => 'raw',
		),
		//'create_user_id',
		//'create_date',
		//'last_update_user_id',
		//'last_update_date',
		array(
			'name' => 'state',
			'value' => $model->getState(),
		),
	),
)); ?>
