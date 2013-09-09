<?php

class SettingsController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('index'),
				'roles'=>array('administrator'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Settings form
	 */
	public function actionIndex()
	{
		$model = new SettingsForm();
		if(isset($_POST['SettingsForm']))
		{
			$model->attributes=$_POST['SettingsForm'];
			if($model->validate())
			{
				Yii::app()->config->set("SITE_NAME", $model->siteName);
				Yii::app()->config->set("SITE_EMAIL", $model->siteEmail);
				Yii::app()->config->set("SITE_URL", $model->siteUrl);
				
				if($model->transportType === SettingsForm::TRANSPORT_TYPE_PHP)
					$model->transportOptions = null;
				else
				{
					$model->transportOptions = array(
						'host' => $model->smptHost,
						'port' => $model->smptPort,
						'username' => $model->smptUsername,
						'password' => $model->smptPassword,
					);
				}
				
				Yii::app()->config->set("Swift_Mailer", array(
					'transportType' => $model->transportType,
					'transportOptions' => $model->transportOptions,
				));
				
				Yii::app()->user->setFlash('success','Параметры успешно обновлены');
				$this->refresh();
			}
		}
		$this->render('index', array(
			"model" => $model,
		));
	}
}
