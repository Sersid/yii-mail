Yii-mail
==========

## Installation

      'import' => array(
        'backend.extensions.yii-mail.models.*',
      ),
      'components' => array(
        '...',
          'mail' => array(
          'class' => 'app.extensions.yii-mail.YiiMail',
        ),
        'config'=>array(
      	'class' => 'app.extensions.yii-config.EConfig',
      	'...',
        ),
        '...',
      ),

## Usage

      Yii::app()->mail->send("USER_REGISTER", array(
        "#USER_LOGIN#" => $model->login,
        "#USER_EMAIL#" => $model->email,
        "...",
      ));