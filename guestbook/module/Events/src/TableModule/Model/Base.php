<?php
namespace Events\TableModule\Model;
use Zend\Db\ {Adapter\Adapter, TableGateway\TableGateway};
abstract class Base
{
    public static $tableName;
    protected $tableGateway;
    public function __construct(Adapter $adapter)
    {
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
    }
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
