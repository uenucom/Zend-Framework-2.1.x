<?php

namespace Album\Model;

use Zend\Db\Sql\Sql;

$sql = new Sql($adapter);
$select = $sql->select();
$select->from('foo');
$select->where(array('id' => 2));

$selectString = $sql->getSqlStringForSqlObject($select);
$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);