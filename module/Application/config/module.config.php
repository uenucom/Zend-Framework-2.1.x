<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//use Zend\Mail;
//use Zend\Mail\Transport\Smtp as SmtpTransport;
//use Zend\Mail\Transport\SmtpOptions;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

//use Zend\Navigation;


class IndexController extends AbstractActionController {

    public function indexAction() {
        return new ViewModel();
    }

    public function nolayoutAction() {
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    public function infoAction() {
        $view = new ViewModel(array(
            'message' => 'Hello world',
        ));

        // Disable layouts; `MvcEvent` will use this View Model instead
        $view->setTerminal(true); //禁用布局，但必须有对应模板
        echo time();
        $view->setTemplate('application/index/testbak');
        return $view;
    }

    public function jsonAction() {
        $path = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
        $config = \Zend\Config\Factory::fromFile($path . '/config/autoload/configs.ini');
        print_r($config);

        $variables = array('Foo' => 'Bar', 'Baz' => 'Test');
        $json = new JsonModel($variables);
        return $json;
    }

    public function mailaAction() {
        $message = new Message();
        $message->addTo('tianhuimin@duoku.com')
                ->addFrom('tianhuimin@duoku.com')
                ->setSubject('Greetings and Salutations!')
                ->setBody("Sorry, I'm going to be late today!");
        $message->setEncoding("GB2312");//
        //$message->setEncoding("UTF-8");

// Setup SMTP transport using LOGIN authentication
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'name' => 'smtp.qiye.163.com',
            'host' => '127.0.0.1',
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'tianhuimin@duoku.com',
                'password' => 'helloTHM8',
            ),
        ));
        $transport->setOptions($options);
        $transport->send($message);
    }

    public function mailAction() {


        // Setup SMTP transport using PLAIN authentication
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'name' => 'smtp.qiye.163.com', //SMTP host;
            'host' => 'smtp.qiye.163.com', //Remote hostname
            'port' => 25,
            'connection_class' => 'login', //login plain
            'connection_config' => array(
                'username' => 'tianhuimin@duoku.com',
                'password' => 'helloTHM8',
                'ssl' => 'tls',
            ),
        ));
        $transport->setOptions($options);


//        $mail = new \Zend\Mail\Message();
//        $mail->setBody('This is the text of the email.');
//        $mail->setFrom('Freeaqingme@example.org', 'Sender\'s name');
//        $mail->addTo('tianhuimin@duoku.com', 'Name of recipient');
//        $mail->setSubject('TestSubject');
        
        $message = new Message();
        $message->addTo('tianhuimin@duoku.com', '李贵兵')
                ->addFrom('tianhuimin@duoku.com', '田慧民test')
                ->setSubject('测试邮件!'.date("Y-m-d H:i:s", time()))
                ->setBody(iconv("UTF-8", "GBK", "测试邮件"));
        //$message->setEncoding("GBK");//
        $message->setEncoding("UTF-8");

        //$transport = new \Zend\Mail\Transport\Sendmail();
        $transport->send($message);
        echo "send ok";
        return $this->getResponse();
    }

    public function timeAction() {
        header("content-type:application/json");
        $list = array(
            "resutl" => 1,
            "info" => array(1, 2, 3)
        );
        echo json_encode($list);
        return $this->getResponse();
    }

    public function dataAction() {
        $list = array("a" => array(1, 2, 3), "b" => 111);
        $json = \Zend\Json\Json::encode($list);
        //echo \Zend\Json\Json::prettyPrint($json, array("indent" => " "));
        $phpNative = \Zend\Json\Json::decode($json, \Zend\Json\Json::TYPE_ARRAY); //TYPE_OBJECT
        print_r($phpNative);
        return $this->getResponse();
    }

    public function testAction() {
        //$this->layout()->disableLayout();
        //$this->getLocator()->get('view')->layout()->disableLayout();
        //echo time();
//        $list = array(
//            "resutl" => 1,
//            "info" => array(1, 2, 3)
//        );
        //echo json_encode($list);
        //$viewModel = new ViewModel($list);
        //$viewModel ->setTerminal(true);
        //$viewModel->setTerminal($this->getRequest()->isXmlHttpRequest());
        //return FALSE;
        //$message = $this->params()->fromQuery('message', 'foo');
        //return new ViewModel(array('message' => time()));
        //return $this->getResponse()->setContent(json_encode($list));

        $view = new ViewModel(array(
            'message' => 'Hello world',
        ));

        // Disable layouts; `MvcEvent` will use this View Model instead
        $view->setTerminal(true);

        return $view;
    }

}
