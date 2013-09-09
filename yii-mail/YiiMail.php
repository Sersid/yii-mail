<?php

class YiiMail extends CApplicationComponent
{
	/**
	 * @var bool whether to log messages using Yii::log().
	 * Defaults to true.
	 */
	public $logging = false;

	/**
	 * @var bool whether to disable actually sending mail.
	 * Defaults to false.
	 */
	public $dryRun = false;

	/**
	 * Config component id
	 * @var type string
	 */
	public $configID = 'config';

	/**
	 * Config
	 * @var array
	 */
	protected static $_config;

	/**
	 * @var Swift_Mailer::newInstance()
	 */
	protected $mailer;

	/**
	 * @var Swift_MailTransport
	 */
	protected $transport;

	/**
	 * @var EConfig
	 */
	protected $config;

	/**
	 * @var string
	 */
	protected $siteName;

	/**
	 * @var string
	 */
	protected $siteEmail;

	/**
	 * @var string
	 */
	protected $siteUrl;

	/**
	 * Init component
	 */
	public function init()
	{
		Yii::import('backend.modules.mail.models.*');
	}

	/**
	 * Get config
	 * @return array $this->_config
	 */
	protected function loadConfig()
	{
		if(self::$_config === null)
		{
			self::$_config = $this->getConfigComponent()->get("Swift_Mailer", array(
				'transportType' => 'php',
				'transportOptions' => null,
			));
		}
		return self::$_config;
	}

	/**
	 * Get config value
	 * @param string $name
	 * @return mixed
	 */
	protected function getConfig($name)
	{
		$config = $this->loadConfig();
		return $config[$name];
	}

	/**
	 * @return Econfig
	 */
	protected function getConfigComponent()
	{
		if($this->config === null)
		{
			$this->config = Yii::app()->getComponent($this->configID);
		}
		return $this->config;
	}

	/**
	 * Send message
	 */
	public function send($eventCode, array $params = null)
	{
		$event = CoreMailEvent::model()->actived()->findByAttributes(array(
			'code' => $eventCode,
		), array(
			'select' => 't.id',
			'with' => array(
				'templates' => array(
					'condition' => 'templates.state='.CoreMailTemplate::STATE_ACTIVE,
					'select' => 'subject, from, to, сс, bss, reply_to, priority, content_type, body'
				),
			),
		));

		if(!empty($event))
		{
			$params["#SITE_NAME#"] = $this->getSiteName();
			$params["#SITE_EMAIL#"] = $this->getSiteEmail();
			$params["#SITE_URL#"] = $this->getSiteUrl();

			foreach($event->templates as $template)
			{
				$template->replaceData($params);

				if(empty($template->from) || empty($template->to))
					continue;

				// Create the message
				$message = Swift_Message::newInstance();
				$message->setFrom($template->from);
				$message->setTo($template->to);

				if(!empty($template->subject))
					$message->setSubject($template->subject);

				if(!empty($template->content_type))
					$message->setContentType($template->getContentType());

				if(!empty($template->body))
					$message->setBody($template->body);

				if(!empty($template->priority))
					$message->setPriority($template->priority);

				if(!empty($template->reply_to))
					$message->setReplyTo($template->reply_to);

				if(!empty($template->cc))
					$message->setCc($template->cc);

				if(!empty($template->bcc))
					$message->setBcc($template->bcc);


				// Send message
				if($this->logging === true)
					self::log($message);

				if($this->dryRun !== true)
					$this->getMailer()->send($message);
			}
		}
	}

	/**
	 * Gets the SwiftMailer transport class instance, initializing it if it has
	 * not been created yet
	 * @return mixed {@link Swift_MailTransport} or {@link Swift_SmtpTransport}
	 * @throws CException
	 */
	protected function getTransport()
	{
		if($this->transport === null)
		{
			$transportType = $this->getConfig('transportType');
			$transportOptions = $this->getConfig('transportOptions');

			switch($transportType)
			{
				case 'php':
					$this->transport = Swift_MailTransport::newInstance();
					if($transportOptions !== null)
						$this->transport->setExtraParams($transportOptions);
					break;
				case 'smtp':
					$this->transport = Swift_SmtpTransport::newInstance();
					foreach($transportOptions as $option => $value)
						$this->transport->{'set'.ucfirst($option)}($value); // sets option with the setter method
					break;
				default :
					throw new CException("Transport type is invalid (".$transportType.")");
					break;
			}
		}

		return $this->transport;
	}

	/**
	 * Gets the SwiftMailer {@link Swift_Mailer} class instance
	 * @return Swift_Mailer
	 */
	public function getMailer()
	{
		if($this->mailer === null)
			$this->mailer = Swift_Mailer::newInstance($this->getTransport());

		return $this->mailer;
	}

	/**
	 * Logs a YiiMailMessage in a (hopefully) readable way using Yii::log.
	 * @return string log message
	 */
	public static function log(Swift_Message $message)
	{
		$msg = 'Sending email to '.implode(', ', array_keys($message->getTo()))."\n".
				implode('', $message->getHeaders()->getAll())."\n".
				$message->getBody()
		;
		Yii::log($msg, CLogger::LEVEL_INFO);
		return $msg;
	}

	/**
	 * Site name
	 * @return string
	 */
	protected function getSiteName()
	{
		if($this->siteName === null)
		{
			$this->siteName =  $this->getConfigComponent()->get('SITE_NAME', Yii::app()->name);
		}
		return $this->siteName;
	}

	/**
	 * Site name
	 * @return string
	 */
	protected function getSiteEmail()
	{
		if($this->siteEmail === null)
		{
			$this->siteEmail =  $this->getConfigComponent()->get('SITE_EMAIL', Yii::app()->params["adminEmail"]);
		}
		return $this->siteEmail;
	}

	/**
	 * Site name
	 * @return string
	 */
	protected function getSiteUrl()
	{
		if($this->siteUrl === null)
		{
			$default = 'http://'.$_SERVER["HTTP_HOST"];
			$this->siteUrl = rtrim($this->getConfigComponent()->get('SITE_URL', $default), '/');
		}
		return $this->siteUrl;
	}
}