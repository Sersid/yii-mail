<?php
$this->pageTitle = 'Типы почтовых событий';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Типы почтовых событий',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить тип', 'url' => array('create')),
);
?>
<?php
$this->widget('yiiwheels.widgets.grid.WhGridView',array(
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' => 'id',
			'headerHtmlOptions' => array('class' => 'span1'),
		),
		array(
			'name' => 'code',
			'value' => 'CHtml::link($data->code,array("view","id"=>$data->id))',
			'headerHtmlOptions' => array('class' => 'span3'),
			'type' => 'raw',
		),
		'name',
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
