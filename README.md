Yii2-Start shoppinglists module.
========================
This module provide a shoppinglists managing system for Yii2-Start application.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require  yii3ds/yii2-3ds-shoppinglists-module "*"
```

or add

```
"yii3ds/yii2-3ds-shoppinglists-module": "*"
```

to the require section of your `composer.json` file.

Configuration
=============

- Add module to config section:

```
'modules' => [
    'shoppinglists' => [
        'class' => 'yii3ds\shoppinglists\Module'
    ]
]
```

- Run migrations:

```
php yii migrate --migrationPath=@yii3ds/shoppinglists/migrations
```

- Run RBAC command:

```
php yii shoppinglists/rbac/add
```
