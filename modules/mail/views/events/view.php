<?php
/* @var $this EvenvController */
/* @var $model CoreMailEvent */
$this->pageTitle = 'Тип "'.$model->name.'"';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Типы почтовых событий' => array("index"),
	'Тип "'.$model->name.'"',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить тип', 'url' => array('create')),
);
$this->leftMenu = array(
	array('label' => 'Добавить шаблон', 'url' => array('/mail/templates/create','event'=>$model->id)),
	array('label' => 'Редактировать', 'url' => array('update','id'=>$model->id)),
	array('label' => 'Удалить', 'url' => array('delete','id'=>$model->id), 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить данный тип почтового события?')),
);
?>
<?php
$this->widget('backend.widgets.SersDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'code',
        'name',
		 array(
			'name' => 'desc',
			'value' => nl2br(CHtml::encode($model->desc)),
			'type' => 'raw',
		),
        //'create_user_id',
        //'create_date',
        //'last_update_user_id',
       // 'last_update_date',
        array(
			'name' => 'state',
			'value' => $model->getState(),
		),
    ),
)); ?>