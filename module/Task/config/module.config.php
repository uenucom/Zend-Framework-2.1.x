<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Task\Controller\Index' => 'Task\Controller\IndexController',
        ),
    ),
    'custom' => array('config1' => array('key1' => 1), 'config2' => array('key2' => 2)),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            /*
              //默认路由 配置一次
              'home' => array(
              'type' => 'Zend\Mvc\Router\Http\Literal',
              'options' => array(
              'route' => '/',
              'defaults' => array(
              //'controller' => 'Application\Controller\Index',
              'controller' => 'Album\Controller\Album', // <-- change here
              'action' => 'index',
              ),
              ),
              ),
             * */
            'Task' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/task',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Task\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                //more
                ),
            ),
            'Taskinfo' => array(
                'type' => 'segment', //literal 逐步  segment 分割
                'options' => array(
                    'route' => '/task[/:action][.:html|jsp]', //(?:\.(?:jpeg|htm|html|shtml|php|jsp|asp|aspx))?
                    //'route' => '/task/info.html', //
                    'constraints' => array(
                        //'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    //'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Task\Controller\Index',
                        'action' => 'info',
                    ),
                ),
            ),
        //more
        ),
    ),
    
    
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'task/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'task/index/index'        => __DIR__ . '/../view/task/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
        'ViewJsonStrategy',
        ),
//        'template_map' => array(
//            //'task/layout' => __DIR__ . '/../view/task/layout/layout.phtml',
//            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
//        ),
//        'template_path_stack' => array(
//            //'task' => __DIR__ . '/../view',
//            __DIR__ . '/../view',
//        ),
    ),
);
