Mailchimp
==============

![License](https://img.shields.io/packagist/l/panix/mod-mailchimp.svg)
![Latest Stable Version](https://img.shields.io/github/release/panix/mod-mailchimp.svg)
![Latest Release Date](https://img.shields.io/github/release-date/panix/mod-mailchimp.svg)
![Latest Commit](https://img.shields.io/github/last-commit/panix/mod-mailchimp.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/panix/mod-mailchimp.svg)](https://packagist.org/packages/panix/mod-mailchimp)

MailChimp extension to manage the Mailchimp Email Marketing Platform:

 - Website: https://www.mailchimp.com/
 - PHP API: https://github.com/drewm/mailchimp-api
 - Documentation: https://developer.mailchimp.com/documentation/mailchimp/

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ php composer.phar require panix/mod-mailchimp "*"
```

or add

```
"panix/mod-mailchimp": "*"
```

Configuration
-------------

Set on your configuration file

```
use panix\mod\mailchimp\components\Mailchimp as MailchimpComponent;
use panix\mod\mailchimp\Mailchimp;

'components' => [

	'mailchimp' => [
		'class' => MailchimpComponent::class,
		'apiKey' => 'YOUR_MAILCHIMP_API_KEY'
	],

],

'modules' => [ 
    
    'mailchimp' => [
        'class' => Mailchimp::class,
        'showFirstname' => true,
        'showLastname' => true
    ]
    
]
```

## Overrides

Override controller example, on modules config

```
'modules' => [ 

	'mailchimp' => [
		'class' => Mailchimp::class,
		'controllerMap' => [
			'default' => 'app\controllers\DefaultController',
		]
	]
	
],
```

Override view example, on components config

```
'components' => [ 

	'view' => [
		'theme' => [
			'pathMap' => [
				'@mailchimp/views/default' => '@app/views/mailchimp/default',
			],
		],
	],
	
],
```

Usage
---------------------------

```
\Yii::$app->mailchimp;
\Yii::$app->mailchimp->getClient();
\Yii::$app->mailchimp->getLists();
\Yii::$app->mailchimp->getListMembers($listID);
```

Widget Subscription Example
---------------------------

```
<?= Subscription::widget([
    'list_id' => 'MYLISTID' // if not set raise Error
]) ?>
```

alternative to list_id you can set an list_array to set a list_id to a specific language

```
<?= Subscription::widget([
    'list_array' => [
        'en' => 'MYLISTID_EN',
        'es' => 'MYLISTID_ES',
        'it' => 'MYLISTID_IT',                        
    ]
]) ?>
```

Actions
-------

<ul> 
  <li>Lists View: PathToApp/index.php?r=mailchimp/default/lists</li>
  <li>Lists View with Pretty Urls: PathToApp/mailchimp/default/lists</li>
  <li>List View: PathToApp/index.php?r=mailchimp/default/list?id=XXX&name=XXX</li>
  <li>List View with Pretty Urls: PathToApp/mailchimp/default/list?id=XXX&name=XXX</li>
</ul>
