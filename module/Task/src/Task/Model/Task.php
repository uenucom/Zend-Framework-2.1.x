<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Task\Model;

use Zend\Db\Adapter\Adapter as Adapter;
use Zend\Db\Sql\Sql as Sql;
use Zend\Db\ResultSet as ResultSet;

class Task {

    protected $adapter;

    public function __construct($conf) {
        $this->adapter = new Adapter($conf);
    }

    public function getList() {
//        $app = $this->getEvent()->getApplication("application");
//        //$result = $this->getMethodFromAction("test");
//        $config = $app->getConfig();
//        print_r($config['db2']);exit();
//        print_r($adapter);return FALSE;
        //$result = $adapter->query('SELECT * FROM `album` WHERE `id` = ?', array(5));
        //print_r($result);
        $sql = new Sql($this->adapter);
        $select = $sql->select();
//        $select = $adapter->select();
        //$select->from('album');
        $select->from(array('a' => 'album'));  // base table
        $select->join(array('b' => 'newtable'), // join table with alias
                'a.id = b.uid', $select::SQL_STAR, $select::JOIN_LEFT); //SQL_STAR  JOIN_RIGHT  JOIN_LEFT  JOIN_OUTER  JOIN_INNER 
        //$select->where(array('id' => 2, 'id'=>3));
        //$select->where("id < 10");//array(1, 2, 3)
        $select->where(array("id" => array(1, 2, 3))); //
        //$sqls = $select->getSqlString();
        // echo $sqls;//exit();
        //$resulta = new DbSelect($select, $adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result;
    }

    public function glist() {
        $sql = new Sql($this->adapter);
        $select = $sql->Select('newtable');
        $select->limit(5);
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
        return $result;
    }

    public function insert() {
        //artist	title
        $sql = new Sql($this->adapter);
        $insert = $sql->insert('album');
        $insert->values(array('artist' => 'test', 'title' => 'go go go'), $insert::VALUES_MERGE);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();
    }

    public function update() {
        $sql = new Sql($this->adapter);
        $update = $sql->update('album');
        $update->set(array('artist' => 'bar', 'title' => 'bax'));
        $update->where(array("id" => array(14, 15, 16)));
        $statement = $sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        //$selectString = $sql->getSqlStringForSqlObject($update);
        //$results = $this->adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
    }

    public function delete() {
        $sql = new Sql($this->adapter);
        $delete = $sql->delete('album');
        //$update->set(array('artist' => 'bar', 'title' => 'bax'));
        $delete->where(array("id" => array(20, 21, 22, 23, 24, 25)));
        $statement = $sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();
    }

}
