<?php

return CMap::mergeArray(
                require(dirname(__FILE__) . '/main.php'), array(
            'components' => array(
                'fixture' => array(
                    'class' => 'system.test.CDbFixtureManager',
                ),
                /* uncomment the following to provide test database connection 
                  'db' => array(
                  'connectionString' => 'DSN for test database',
                  ), */
                'db' => array(
                    'connectionString' =>
                    'mysql:host=localhost;dbname=trackstar_test',
                    'emulatePrepare' => true,
                    'username' => 'root',
                    'password' => 'scoupi',
                    'charset' => 'utf8',
                ),
                
                //'cache' => array(
                  //  'class' => 'system.caching.CFileCache',
                    //'cachePath' => 'C:'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'Yii'.DIRECTORY_SEPARATOR.'xampp'.DIRECTORY_SEPARATOR.'htdocs'.DIRECTORY_SEPARATOR.'trackstar'.DIRECTORY_SEPARATOR.'protected'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'test',
                    //'enabled'=>!YII_DEBUG,  // enable caching in non-debug mode
                //),
            ),
                )
);
