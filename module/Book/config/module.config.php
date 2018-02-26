<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Book\Controller\Index' => 'Book\Controller\IndexController',
            //'Book\Controller\Tianhm' => 'Book\Controller\TianhmController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'book' => array(
                'type' => 'segment', //literal  segment
                'options' => array(
                    'route' => '/book[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Book\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
            ///
            'tianhma' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/book/route',
                    'defaults' => array(
                        'controller' => 'Book\Controller\Index',
                        'action' => 'test',
                    ),
                ),
            ),
        ///
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
           // 'book' => __DIR__ . '/../view',
            __DIR__ . '/../view',
        ),
    ),
);