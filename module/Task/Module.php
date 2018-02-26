<?php

namespace Task;

use Task\Model\TaskList;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $mvcEvent) {
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        // Register a dispatch event
        $application = $mvcEvent->getParam('application');
        $application->getEventManager()->attach('dispatch', array($this, 'setLayout'));
    }

    public function setLayout($mvcEvent) {
        $matches = $mvcEvent->getRouteMatch();
        $controller = $matches->getParam('controller');
        if (false === strpos($controller, __NAMESPACE__)) {
            // not a controller from this module
            return false;
        }
        // Set the layout template
        $viewModel = $mvcEvent->getViewModel();
        $viewModel->setTemplate('task/layout');
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // getAutoloaderConfig() and getConfig() methods here
    // Add this method:
    public function getServiceConfig() {
        return array(
            'factories' => array(
                 'Task\Model\TaskList' => function($sm) {
            $tableGateway = $sm->get('TaskListGateway');
            $table = new TaskList($tableGateway);
            return $table;
        },
                'TaskListGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            //$resultSetPrototype->setArrayObjectPrototype(new TaskList());
            return new TableGateway('newtable', $dbAdapter, null, $resultSetPrototype);
        },
               
            ),
        );
    }

}
