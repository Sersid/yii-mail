<?php
$this->pageTitle = 'Добавить тип почтовых событий';
$this->breadcrumbs+=array(
	'Почта' => array("/mail"),
	'Типы почтовых событий' => array("index"),
	'Редактировать тип почтовых событий #'.$model->id,
);
$this->menu = array(
	array('label' => 'Список', 'url' => array('index'), 'active' => true),
	array('label' => 'Добавить тип', 'url' => array('create')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>