<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
            'Album\Controller\Tianhm' => 'Album\Controller\TianhmController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
                'type' => 'segment', //literal  segment
                'options' => array(
                    'route' => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action' => 'index',
                    ),
                ),
            ),
            ///
            'tianhm' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/album/tianhm',
                    'defaults' => array(
                        'controller' => 'Album\Controller\Tianhm',
                        'action' => 'index',
                    ),
                ),
            ),
        ///
        ),
    ),
    'view_manager' => array(
        'display_exceptions' => true,
        'template_map' => array(//配置分页控件模板路径
            'pagination/search' => __DIR__ . '/../view/pagination/search.phtml',
        ),
        'template_path_stack' => array(
            //'album' => __DIR__ . '/../view',
            __DIR__ . '/../view',
        ),
        'strategies' => array(//配置可以以json格式返回
            'ViewJsonStrategy',
        ),
    ),
);
