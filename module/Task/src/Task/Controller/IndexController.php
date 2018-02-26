<?php

namespace Task\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Task\Model\TaskList;
use Task\Model\Task;
use Zend\Ldap\Ldap;
////
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as AuthAdapter;
use Zend\Config\Reader\Ini as ConfigReader;
use Zend\Config\Config;
use Zend\Log\Logger;
use Zend\Log\Writer\Stream as LogWriter;
use Zend\Log\Filter\Priority as LogFilter;

class IndexController extends AbstractActionController {

    protected $taskList;
    protected $task;

    public function getTaskList() {
        if (!$this->taskList) {
            $sm = $this->getServiceLocator();
            $this->taskList = $sm->get('Task\Model\TaskList');
        }
        return $this->taskList;
    }

    public function indexAction() {
        $ViewModel = new ViewModel();
        $ViewModel->setVariable("result", $this->getTaskList()->getList());
        return $ViewModel;
    }

    public function doAction() {
        $view = new ViewModel(array(
            'message' => 'Hello world',
        ));

        $view->setVariable("result", time());
        // Disable layouts; `MvcEvent` will use this View Model instead
        $view->setTerminal(true);  //加此代码

        return $view;
    }

    public function infoAction() {
        header("content-type:text/html;charset=utf-8");
        echo $this->getRequest()->getContent("vip");
        echo "<br />";
        echo $this->params()->fromRoute("action");
        echo "<br />";
        print_r($this->params()->fromQuery('vip'));
        echo "<br />";
        print_r($this->params()->fromQuery("test"));
        print_r($this->params()->fromPost());
        echo "<br />";
        echo!empty($_GET['vip']) ? $_GET['vip'] : '';
        echo "<br />";
        //return new ViewModel();
        echo date("Y-m-d H:i:s", strtotime("-1 years"));
        //$viewModel = new ViewModel();
        //$viewModel->setTerminal(true);//禁用布局，但必须有对应模板
        //return $viewModel;
        return $this->getResponse();
    }

    public function newldapAction() {

        //$username = $this->getRequest()->getPost('username');
        //$password = $this->getRequest()->getPost('password');


        $auth = new AuthenticationService();
        $path = dirname(dirname(dirname(dirname(dirname(__DIR__))))) . "/config/autoload/";
        $configReader = new ConfigReader();
        $configData = $configReader->fromFile($path . './ldap.ini');
        $config = new Config($configData, true);
        $log_path = $config->ldap->log_path;
        $options = $config->ldap->toArray();
        unset($options['log_path']);
        $username = "tianhuimin@duoku.com";
        $password = 'helloTHM9';
        $adapter = new AuthAdapter($options, $username, $password);
        $result = $auth->authenticate($adapter);

        if ($log_path) {
            $messages = $result->getMessages();
            print_r($messages);
            return '';
            $logger = new Logger;
            $writer = new LogWriter($log_path);

            $logger->addWriter($writer);

            $filter = new LogFilter(Logger::DEBUG);
            $writer->addFilter($filter);

            foreach ($messages as $i => $message) {
                if ($i-- > 1) { // $messages[2] and up are log messages
                    $message = str_replace("\n", "\n  ", $message);
                    $logger->debug("Ldap: $i: $message");
                }
            }
        }
    }

    public function ldapAction() {
        $acctname = 'tianhuimin@duoku.com';
        $password = 'helloTHM9';
//        $password = 'helloTHMa9';
        $options = array(
            'host' => 'duoku.com',
            //'useStartTls'  => true,
            'username' => $acctname,
            'password' => $password,
            'bindRequiresDn' => false, //note that the bindRequiresDn option is important if you are not using AD
            'accountDomainName' => 'duoku.com',
            //'baseDn' => 'CN=Users,DC=duoku,DC=com',//ou=duoku,dc=duoku,dc=com
            'baseDn' => 'ou=duoku,DC=duoku,DC=com', //ou=duoku,dc=duoku,dc=com
                //CN=Users,DC=w,DC=net
        );
        //$ldap = new Ldap($options);//$options
        //$acctname = $ldap->getCanonicalAccountName('', \Zend\Ldap\Ldap::ACCTNAME_FORM_DN);
        //echo "$acctname\n";
        //echo "Trying to bind using server options for '$name'\n";
        $ldap = new Ldap();
        $ldap->setOptions($options);
        try {
            $ldap->bind($acctname, $password);
            $acctname = $ldap->getCanonicalAccountName($acctname);
            echo "SUCCESS: authenticated $acctname\n";
            //$ldap->bind();
            //$ri = new \Zend\Ldap\Ldap\RecursiveIteratorIterator($ldap->getBaseNode(), RecursiveIteratorIterator::SELF_FIRST);
            //foreach ($ri as $rdn => $n) {
            //    var_dump($n);
            //}
            //return;
        } catch (Zend\Ldap\Exception\LdapException $zle) {
            echo '  ' . $zle->getMessage() . "\n";
            if ($zle->getCode() === Zend\Ldap\Exception\LdapException::LDAP_X_DOMAIN_MISMATCH) {
                //continue;
            }
        }
        return $this->getResponse();
    }

    public function testAction() {

        header("charset=utf-8");

        $app = $this->getEvent()->getApplication("application");
        //$result = $this->getMethodFromAction("test");
        $config = $app->getConfig();
        //print_r($config['db']);
        $info = new Task($config['db']);
        //$result = $info->getList();
        $result = $info->gList();
        //$info->update();
//          $info->insert();
        $info->delete();
//        $adapter = new \Zend\Db\Adapter\Adapter($config['db']);
//        //$result = $adapter->query('SELECT * FROM `album` WHERE `id` = ?', array(5));
//        //print_r($result);
//        $sql = new Sql($adapter);
//        $select = $sql->select();
////        $select = $adapter->select();
//        //$select->from('album');
//        $select->from(array('a' => 'album'));  // base table
//       $select->join(array('b' => 'newtable'),     // join table with alias
//        'a.id = b.uid', $select::SQL_STAR, $select::JOIN_LEFT); //SQL_STAR  JOIN_RIGHT  JOIN_LEFT  JOIN_OUTER  JOIN_INNER 
//        //$select->where(array('id' => 2, 'id'=>3));
//        //$select->where("id < 10");//array(1, 2, 3)
//        $select->where(array("id"=>array(1, 2, 3)));//
//        //$sqls = $select->getSqlString();
//        // echo $sqls;//exit();
//        //$resulta = new DbSelect($select, $adapter);
//        $statement = $sql->prepareStatementForSqlObject($select);
//        $result = $statement->execute();
//        print_r($result);
//        foreach ($result as $arr) {
//             print_r($arr);
//        }
//        echo "test";
        //return $this->getResponse();
        $list = array(
            array("id" => 1, "name" => "afdsa", "age" => 12),
            array("id" => 2, "name" => "111", "age" => 12),
            array("id" => 3, "name" => "afdsa", "age" => 12),
            array("id" => 4, "name" => "2", "age" => 12),
            array("id" => 5, "name" => "dsa", "age" => 12),
            array("id" => 6, "name" => "as", "age" => 12),
            array("id" => 7, "name" => "z", "age" => 12),
            array("id" => 8, "name" => "z", "age" => 12),
        );
        $view = new ViewModel();
        $view->setVariable('list', $list);
        $view->setVariable('result', $result);
        return $view;
    }

    public function sqlAction() {
        //$app = $this->getEvent()->getApplication("application");
        //$result = $this->getMethodFromAction("test");
        //$config = $app->getConfig();
        //$adapter = new \Zend\Db\Adapter\Adapter($config['db2']);
        //$sql = new Sql();
//        $select = new Select();
//        //$select = $sql->select();
//        $select->from('album');
//        $select->where(array('id' => 2));
//        $selectString =$select;
//        //$selectString = $sql->getSqlStringForSqlObject($select);
//        //$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
//        print_r($selectString);
//        
        //$db = $this->getServiceLocator()->get('db');
        //$table = new TableGateway('album', $db);
//        $cache = $this->getServiceLocator()->get('cache');
//        if (!$value = $cache->getItem('key1')) {
//            $cache->setItem('key1', time());
//        }
//        echo $value;
        $config = $this->getServiceLocator()->get('config');
        $custom = $config['custom'];
        print_r($custom);
        //return false;
        //$table->insert(array('msg' => '我是h5b.net的测试，哈哈！'));
        return $this->getResponse();
    }

}
