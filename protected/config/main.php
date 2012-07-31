<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'TrackStar',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.admin.models.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'scoupi',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin',
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<pid:\d+>/commentfeed' => array('site/commentFeed', 'urlSuffix' => '.xml', 'caseSensitive' => false),
                'commentfeed' => array('comment/feed', 'urlSuffix' => '.xml', 'caseSensitive' => false),
            ),
        ),
        /* RBE : desactivate sqlite database
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ), */
        // uncomment the following to use a MySQL database

        'db' => array(
            //'connectionString' => 'mysql:host=localhost;dbname=trackstar_dev',
            'connectionString' => 'mysql:host=mysql-shared-02.phpfog.com;dbname=rwinayii_phpfogapp_com',
            'class' => 'CDbConnection',
            'emulatePrepare' => true,
            //'username' => 'root',
            //'password' => 'scoupi',
            'username' => 'rwina36-34-51534',
            'password' => 'yU17R77M22Vq',
            'charset' => 'utf8',
            'schemaCachingDuration' => 60,
        ),
        //add roles and authorization manager
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels'=>'error',
                    //'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info, trace',
                    'logFile' => 'infoMessages.log',
                    'maxFileSize' => '100',  //in kilobytes
                    'maxLogFiles' => 5,
                ),
                // uncomment the following to show log messages on web pages
                //disable this before deploying
               // array(
               //     'class' => 'CWebLogRoute',
               //     'levels' => 'warning, error',
               // ),
            ),
        ),
        'cache'=>array(
            //'class'=>'system.caching.CFileCache',
            'class'=>'system.caching.CApcCache',
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
    'homeUrl' => '/trackstar/project',
    //'theme'=>'classic',
    'theme' => 'new',
);