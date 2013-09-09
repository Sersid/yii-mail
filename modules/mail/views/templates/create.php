<?php
/* @var $this TemplatesController */
/* @var $model CoreMailTemplate */

$this->pageTitle = 'Добавить шаблон';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Шаблоны писем' => array("index"),
	'Добавить шаблон',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index')),
	array('label' => 'Добавить шаблон', 'url' => array('create'), 'active' => true),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>