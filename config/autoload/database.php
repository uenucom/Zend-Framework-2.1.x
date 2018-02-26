<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return array(
    'db' => array(
        'driver' => 'Pdo',
        'dsn' => 'mysql:dbname=album;host=localhost',
        'username' => 'root',
        'password' => 'tianhm',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
            PDO::ATTR_PERSISTENT => true,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            'buffer_results' => true
        ),
    ),
//    "db2" => array(
//        'driver' => 'Pdo_Mysql',//Mysqli Pgsql Sqlsrv  Pdo_Mysql Pdo_Sqlite Pdo_Pgsql
//        'database' => 'album', 
//        'hostname' => 'localhost', 
//        'port' => '3306', //charset
//        'charset' => 'UTF-8',
//        'username' => 'root',
//        'password' => 'tianhm'
//    ),
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
