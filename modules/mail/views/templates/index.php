<?php
/* @var $this TemplatesController */
/* @var $model CoreMailTemplate */
$this->pageTitle = 'Шаблоны писем';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Шаблоны писем',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить шаблон', 'url' => array('create')),
);
?>
<?php $this->widget('yiiwheels.widgets.grid.WhGridView', array(
	'id'=>$model->getGridId(),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array('class' => 'span1'),
		),
		array(
			'name' => 'event_id',
			'value' => 'CHtml::link(CoreMailEvent::getEventName($data->event_id), array("view", "id" => $data->id))',
			'filter' => CoreMailEvent::getEventsArray(),
			'headerHtmlOptions' => array('class' => 'span4'),
			'type' => 'raw',
		),
		array(
			'name' => 'subject',
			'value' => 'empty($data->subject) ? "-" : $data->subject',
		),
		array(
			'name' => 'state',
			'value' => '$data->getState()',
			'filter' => $model->getStates(),
			'headerHtmlOptions' => array('class' => 'span2'),
		),
		array(
			'class' => 'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
