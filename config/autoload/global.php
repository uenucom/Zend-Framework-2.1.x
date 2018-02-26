<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
return array(
    'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Home',
                 'route' => 'home',
             ),
             array(
                 'label' => 'Page #1',
                 'route' => 'home',
                 'pages' => array(
                     array(
                         'label' => 'Child #1',
                         'route' => 'home',
                     ),
                 ),
             ),
             array(
                 'label' => 'Page #2',
                 'route' => 'home',
             ),
         ),
     ),
    // ...
    'phpSettings' => array(
        'display_startup_errors' => true, //false true
        'display_errors' => true, //false true
        'max_execution_time' => 60,
        'date.timezone' => 'Asia/Shanghai',
        //'mbstring.internal_encoding' => 'UTF-8',
        'default_charset'=>'UTF-8'
    ),
		
    'db' => array(
        'driver' => 'pdo_mysql',//pdo_mysql Pdo
        'dsn' => 'mysql:dbname=album;host=localhost',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY=> true,
            'buffer_results' => true
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'Zend\Db\Adapter\Adapter' => function ($serviceManager) {
        $adapterFactory = new Zend\Db\Adapter\AdapterServiceFactory();
        $adapter = $adapterFactory->createService($serviceManager);

        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($adapter);

        return $adapter;
    }
        ),
    ),
);
