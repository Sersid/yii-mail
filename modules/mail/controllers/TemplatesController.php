<?php

class TemplatesController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', 
				'actions'=>array('create', 'update', 'delete'),
				'roles'=>array('administrator'),
			),
			array('allow', 
				'actions'=>array('index', 'view'),
				'roles'=>array('moderator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout='//layouts/column2';
		$this->render('view',array(
			'model'=>$this->loadModel('CoreMailTemplate',$id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($event=0)
	{
		$model=new CoreMailTemplate;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CoreMailTemplate']))
		{
			$model->attributes=$_POST['CoreMailTemplate'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		else
		{
			$event = (int)$event;
			if(!empty($event))
				$model->event_id = $event;
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel('CoreMailTemplate',$id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CoreMailTemplate']))
		{
			$model->attributes=$_POST['CoreMailTemplate'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel('CoreMailTemplate',$id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new CoreMailTemplate('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CoreMailTemplate']))
			$model->attributes=$_GET['CoreMailTemplate'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
}
