<?php
namespace Events\Model;

use Events\Entity\EventEntityInterface;
use Zend\EventManager\EventManager;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Hydrator\ObjectProperty;
use Psr\Container\ContainerInterface;

class Base implements TableGatewayInterface
{
    public static $tableName;
    protected $tableGateway;
    protected $container;
    public function __construct(Adapter $adapter,
                                //*** LAB: Lab: Object Hydration and Database Operations:
                                //***      need to add an entity instance argument
                                ContainerInterface $container)
    {
        //*** LAB: Object Hydration and Database Operations:
        //***      modify TableGateway creation so that it uses a HydratingResultSet to produce an entity instance
        $this->tableGateway = new TableGateway(static::$tableName, $adapter);
        $this->container = $container;
    }
}
