<?php
/**
 * This is the model class for table "core_mail_event".
 *
 * The followings are the available columns in table 'core_mail_event':
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $desc
 * @property string $create_user_id
 * @property string $create_date
 * @property string $last_update_user_id
 * @property string $last_update_date
 * @property integer $state
 */
class CoreMailEvent extends EActiveRecord
{
	/**
	 * States
	 */
	const STATE_NOT_ACTIVE = 0;
	const STATE_ACTIVE = 1;

	public $state = true;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'core_mail_event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, name, state', 'required'),
			array('code', 'match', 'pattern'=>'/^[A-Z\_\-0-9]{2,100}$/'),
			array('code', 'unique'),
			array('state', 'boolean'),
			array('code, name', 'length', 'max' => 100),
			array('desc', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, name, desc, state', 'safe', 'on' => 'search'),
		);
	}
	
	/**
	 * Scopes
	 * @return array
	 */
	public function scopes()
	{
		return array(
			'actived' => array(
				'condition'=>'t.state='.self::STATE_ACTIVE,
			),
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
			'templates' => array(self::HAS_MANY, 'CoreMailTemplate', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код',
			'name' => 'Название',
			'desc' => 'Описание',
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
		$criteria->compare('code', $this->code, true);
		$criteria->compare('name', $this->name, true);
		//$criteria->compare('desc',$this->desc,true);
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
	 * @return CoreMailEvent the static model class
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
	 * @return self::$_states
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
	 * @return self::$_states
	 */
	public function getState()
	{
		$states = $this->getStates();
		return isset($states[$this->state]) ? $states[$this->state] : "-";
	}
	
	/**
	 * Events
	 * @var array
	 */
	public static $_events;
	
	/**
	 * Events
	 * @return array
	 */
	public static function getEventsArray()
	{
		if(self::$_events === NULL)
		{
			self::$_events = array();
			foreach(self::model()->actived()->findAll(array(
				'select' => 'id, code, name',
			)) as $item)
			{
				self::$_events[$item->id] = '['.$item->code.'] '.$item->name;
			}
		}

		return self::$_events;
	}
	
	/**
	 * Event name
	 * @param integer $id
	 * @return string
	 */
	public static function getEventName($id)
	{
		$events = self::getEventsArray();
		return isset($events[$id]) ? $events[$id] : '-';
	}

	/**
	 * Before delete events
	 * @param type $event
	 */
	protected function beforeDelete()
	{
		CoreMailTemplate::model()->deleteAllByAttributes(array(
			'event_id' => $this->id,
		));
	}
}
