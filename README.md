yii2-backup
===========
Database Backup and Restore functionality

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```

php composer.phar require --prefer-dist yiier/yii2-backup "*"
php composer.phar require funson86/yii2-setting "*"

// or

php composer.phar require --prefer-dist yiier/yii2-backup "*"
```

or add

```
"yiier/yii2-backup": "*",
"funson86/yii2-setting": "*"

// or

"yiier/yii2-backup": "*",
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

main.php

```
'modules' => [
    'setting' => [
        'class' => 'funson86\setting\Module',
        'controllerNamespace' => 'funson86\setting\controllers',
    ],
    'backup' => [
        'class' => 'yiier\backup\Module',
    ],
],

// or

'modules' => [
    'backup' => [
        'class' => 'yiier\backup\Module',
    ],
],
'components' => [
    // ...
    'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@common/mail',
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.xx.xx',
            'username' => 'xxxxx',
            'password' => 'xxxx',
            'port' => 25,
            'encryption' => 'tls',
        ],
    ],
    // ...
],


```

params.php
```
'backupEmail' => 'xxx@xx',
'supportEmail' => 'yyy@yy', // from address must be same as supportEmail
```


add mail/backup.php
```
backup successful ！！！！
```

console\config\main.php
```
    'params' => $params,
    ...
    'controllerMap' => [
        'backup' => [
            'class' => 'yiier\backup\controllers\BackupController',
        ]
    ]
```

console
```
php yii backup
```

Look
----------
https://github.com/iiYii/getyii/commit/b8315d083d5d07969ac163205bf1452216246666