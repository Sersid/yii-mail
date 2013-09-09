<?php
class SettingsForm extends CFormModel
{
	public $transportType;
	public $transportOptions;
	public $siteName;
	public $siteEmail;
	public $siteUrl;
	public $smptHost = 'localhost';
	public $smptPort = 25;
	public $smptUsername;
	public $smptPassword;
	
	const TRANSPORT_TYPE_PHP = 'php';
	const TRANSPORT_TYPE_SMTP = 'smtp';

	/**
	 * Set default data
	 */
	public function init()
	{
		$config = Yii::app()->config->get("Swift_Mailer", array(
			'transportType' => 'php',
			'transportOptions' => null,
		));
		$this->transportType = $config['transportType'];
		$this->siteName = Yii::app()->config->get("SITE_NAME");
		$this->siteEmail = Yii::app()->config->get("SITE_EMAIL");
		$this->siteUrl = Yii::app()->config->get("SITE_URL");
		
		$options = $config['transportOptions'];
		if(!empty($options['host']))
			$this->smptHost = $options['host'];
		
		if(!empty($options['port']))
			$this->smptPort = $options['port'];
		
		if(!empty($options['username']))
			$this->smptUsername = $options['username'];
		
		if(!empty($options['password']))
			$this->smptPassword = $options['password'];
	}
	
	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array('siteName, siteEmail, siteUrl, transportType', 'required'),
			array('transportType', 'in', 'range' => array_flip($this->getTransportTypes())),
			array('smptHost, smptPort, smptUsername, smptPassword', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'siteName' => 'Название сайта',
			'siteEmail' => 'E-mail',
			'siteUrl' => 'Адрес сайта',
			'transportType' => 'Метод отправки',
			'smptHost' => 'Host',
			'smptPort' => 'Port',
			'smptUsername' => 'Username',
			'smptPassword' => 'Password',
		);
	}
	
	/**
	 * Priorities
	 * @var array
	 */
	public static $_types;

	/**
	 * Priorities
	 * @return array self::$_priorities
	 */
	public function getTransportTypes()
	{
		if(self::$_types === NULL)
		{
			self::$_types = array(
				self::TRANSPORT_TYPE_PHP => "PHP",
				self::TRANSPORT_TYPE_SMTP => "SMTP",
			);
		}

		return self::$_types;
	}

	/**
	 * Get priority
	 * @return self::$_states
	 */
	public function getTransportType()
	{
		$types = $this->getTransportTypes();
		return isset($types[$this->transportType]) ? $types[$this->transportType] : '-';
	}
}
