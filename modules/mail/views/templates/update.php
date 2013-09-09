<?php
/* @var $this TemplatesController */
/* @var $model CoreMailTemplate */

$this->pageTitle = 'Редактировать шаблон#'.$model->id;
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Шаблоны писем' => array("index"),
	'Шаблон #'.$model->id => array("view", "id" => $model->id),
	'Редактировать',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить шаблон', 'url' => array('create')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>