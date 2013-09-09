<?php
$this->pageTitle = 'Добавить тип почтовых событий';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Типы почтовых событий' => array("index"),
	'Добавить тип почтовых событий',
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index')),
	array('label' => 'Добавить тип', 'url' => array('create'), 'active' => true),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>