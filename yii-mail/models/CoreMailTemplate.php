<?php
/**
 * This is the model class for table "core_mail_template".
 *
 * The followings are the available columns in table 'core_mail_template':
 * @property string $id
 * @property string $event_id
 * @property string $subject
 * @property string $from
 * @property string $to
 * @property string $сс
 * @property string $bss
 * @property string $reply_to
 * @property string $priority
 * @property integer $content_type
 * @property string $body
 * @property string $create_user_id
 * @property string $create_date
 * @property string $last_update_user_id
 * @property string $last_update_date
 * @property integer $state
 */
class CoreMailTemplate extends EActiveRecord
{
	const STATE_NOT_ACTIVE = 0;
	const STATE_ACTIVE = 1;
	const CONTENT_TYPE_HTML = 1;
	const CONTENT_TYPE_TEXT = 2;
	const PRIORITY_HIGHEST = 1;
	const PRIORITY_HIGH = 2;
	const PRIORITY_NORMAL = 3;
	const PRIORITY_LOW = 4;
	const PRIORITY_LOWEST = 5;

	/**
	 * Init model
	 */
	public function init()
	{
		$this->state = true;
		$this->content_type = self::CONTENT_TYPE_TEXT;
		parent::init();
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'core_mail_template';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, from, to, content_type, body, state', 'required'),
			array('state', 'in', 'range' => array_flip($this->getStates())),
			array('content_type', 'in', 'range' => array_flip($this->getContentTypes())),
			array('priority', 'in', 'range' => array_flip($this->getPriorities())),
			array('event_id', 'in', 'range' => array_flip(CoreMailEvent::getEventsArray())),
			array('subject, from, to, сс, bss', 'length', 'max' => 255),
			array('reply_to', 'length', 'max' => 100),
			array('сс, bss, create_date, last_update_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, event_id, subject, from, to, сс, bss, reply_to, content_type, body, create_user_id, create_date, last_update_user_id, last_update_date, state', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'event' => array(self::BELONGS_TO, 'CoreMailEvent', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Событие',
			'subject' => 'Тема',
			'from' => 'От кого',
			'to' => 'Кому',
			'сс' => 'Копия',
			'bss' => 'Скрытая копия',
			'reply_to' => 'Ответ на сообщение',
			'priority' => 'Важность',
			'content_type' => 'Тип сообщения',
			'body' => 'Сообщение',
			'create_user_id' => 'Create User',
			'create_date' => 'Дата создания',
			'last_update_user_id' => 'Last Update User',
			'last_update_date' => 'Дата последнего изменения',
			'state' => 'Активен',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		$criteria->compare('subject', $this->subject, true);
		//$criteria->compare('from',$this->from,true);
		//$criteria->compare('to',$this->to,true);
		//$criteria->compare('сс',$this->сс,true);
		//$criteria->compare('bss',$this->bss,true);
		//$criteria->compare('reply_to',$this->reply_to,true);
		//$criteria->compare('content_type',$this->content_type);
		//$criteria->compare('body',$this->body,true);
		//$criteria->compare('create_user_id',$this->create_user_id,true);
		//$criteria->compare('create_date',$this->create_date,true);
		//$criteria->compare('last_update_user_id',$this->last_update_user_id,true);
		//$criteria->compare('last_update_date',$this->last_update_date,true);
		$criteria->compare('state', $this->state);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoreMailTemplate the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * States
	 * @var array
	 */
	public static $_states;

	/**
	 * Get states array
	 * @return array self::$_states
	 */
	public function getStates()
	{
		if(self::$_states === NULL)
		{
			self::$_states = array(
				self::STATE_ACTIVE => "Да",
				self::STATE_NOT_ACTIVE => "Нет",
			);
		}

		return self::$_states;
	}

	/**
	 * Get state
	 * @return string
	 */
	public function getState()
	{
		$states = $this->getStates();
		return isset($states[$this->state]) ? $states[$this->state] : "-";
	}

	/**
	 * Content types
	 * @var array
	 */
	public static $_types;

	/**
	 * Content types
	 * @return array self::$_types
	 */
	public function getContentTypes()
	{
		if(self::$_types === NULL)
		{
			self::$_types = array(
				self::CONTENT_TYPE_TEXT => "text/plain",
				self::CONTENT_TYPE_HTML => "text/html",
			);
		}

		return self::$_types;
	}

	/**
	 * Get state
	 * @return string
	 */
	public function getContentType()
	{
		$types = $this->getContentTypes();
		return isset($types[$this->content_type]) ? $types[$this->content_type] : $types[self::CONTENT_TYPE_TEXT];
	}
	
	/**
	 * Priorities
	 * @var array
	 */
	public static $_priorities;

	/**
	 * Priorities
	 * @return array self::$_priorities
	 */
	public function getPriorities()
	{
		if(self::$_priorities === NULL)
		{
			self::$_priorities = array(
				self::PRIORITY_HIGHEST => "Наивысшая",
				self::PRIORITY_HIGH => "Высокая",
				self::PRIORITY_NORMAL => "Нормальная",
				self::PRIORITY_LOW => "Низкая",
				self::PRIORITY_LOWEST => "Очень низкая",
			);
		}

		return self::$_priorities;
	}

	/**
	 * Get priority
	 * @return self::$_states
	 */
	public function getPriority()
	{
		$priorities = $this->getPriorities();
		return isset($priorities[$this->priority]) ? $priorities[$this->priority] : '-';
	}
	
	
	/**
	 * Replace attributes value
	 * @param array $array
	 * @return null
	 */
	public function replaceData(array $array = null)
	{
		if(empty($array))
			return;
		
		foreach($this->getAttributes() as $key => $value)
		{
			if(!empty($value) && in_array($key, array(
				'subject', 'from', 'to', 'сс', 'bss', 'reply_to', 'body',
			)))
			{
				$this->setAttribute($key, strtr($value, $array));
				
				if(in_array($key, array('from', 'to', 'сс', 'bss')))
				{
					$validate = new CEmailValidator();
					$items = explode(",", $this->getAttribute($key));
					$emails = array();
					foreach($items as $item)
					{
						$item = trim($item);
						preg_match("/(.*)<(.*)>/", $item, $match);
						if(empty($match))
						{
							$validate->allowName = false;
							if($validate->validateValue($item))
								$emails[] = $item;
						}
						else
						{
							$validate->allowName = true;
							if($validate->validateValue($item))
								$emails[$match[2]] = $match[1];
						}
					}
					$this->setAttribute($key, empty($emails) ? null : $emails);
				}
			}
		}
	}
}
