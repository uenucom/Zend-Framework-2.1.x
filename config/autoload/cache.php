<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Zend\Cache\StorageFactory;

return array(
    'service_manager' => array(
        'factories' => array(
            'cache' => function () {
                return StorageFactory::factory(
                    array(
                        'adapter' => array(
                            'name' => 'memcache',//apc file memcache
                            'options' => array(
                                'ttl' => 3600
                            ),
                        ),
                        'exception_handler' => array('throw_exceptions' => false),
                    )
                );
            }
        ),
    )
);