CREATE TABLE IF NOT EXISTS `core_mail_event` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `code` varchar(100) NOT NULL COMMENT 'Код',
  `name` varchar(100) NOT NULL COMMENT 'Название',
  `desc` text COMMENT 'Описание',
  `create_user_id` int(10) unsigned DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `last_update_user_id` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL COMMENT 'Дата последнего изменения',
  `state` tinyint(1) NOT NULL COMMENT 'Статус',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `code_2` (`code`,`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Типы почтовых событий' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `core_mail_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(10) unsigned NOT NULL,
  `subject` varchar(255) DEFAULT NULL COMMENT 'Тема',
  `from` varchar(255) NOT NULL COMMENT 'От кого',
  `to` varchar(255) NOT NULL COMMENT 'Кому',
  `сс` varchar(255) DEFAULT NULL COMMENT 'Копия',
  `bss` varchar(255) DEFAULT NULL COMMENT 'Скрытая копия',
  `reply_to` varchar(100) DEFAULT NULL COMMENT 'Ответ на сообщение',
  `priority` tinyint(1) unsigned DEFAULT NULL,
  `content_type` tinyint(1) NOT NULL COMMENT 'Тип сообщения',
  `body` text NOT NULL COMMENT 'Сообщение',
  `create_user_id` int(10) unsigned DEFAULT NULL,
  `create_date` int(11) DEFAULT NULL COMMENT 'Дата создания',
  `last_update_user_id` int(10) unsigned DEFAULT NULL,
  `last_update_date` int(11) DEFAULT NULL COMMENT 'Дата последнего изменения',
  `state` tinyint(1) NOT NULL COMMENT 'Статус',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  KEY `event_id_2` (`event_id`,`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Почтовые шаблоны' AUTO_INCREMENT=1 ;
