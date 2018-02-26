<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Task\Model;

use Zend\Db\TableGateway\TableGateway;
//添加下面几个类的引用 2013.12.2
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\ResultSet;

class TaskList {

    protected $tableGateway;

    //声明排序常量
    const ORDER_DEFAULT = 0; //默认排序
    const ORDER_LATEST = 1; //最新排序

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getOne() {
        
    }

    public function getList() {
        $resultSet = $this->tableGateway->select(function (Select $select) {
       //$select->from(array('a' => 'album'));  // base table
       //$select->join(array('b' => 'newtable'),     // join table with alias
       // 'a.id = b.uid', $select::SQL_STAR, $select::JOIN_LEFT);
        $select->where->like('name', '中国%');
        $select->order('name ASC')->limit(10);});
        return $resultSet;
    }

    public function getListByPage() {
        
    }

}
