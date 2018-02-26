<?php

namespace Book\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        //return new ViewModel();
        echo "book/index";
        return $this->getResponse();
    }

    public function testAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        echo time();
        print_r($this->getRequest());
        return $viewModel;
    }


}

