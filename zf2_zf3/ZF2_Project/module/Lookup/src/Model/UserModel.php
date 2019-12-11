<?php
namespace Lookup\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UserModel
{
    const TABLE_NAME = 'users';
    protected $table;
    public function __construct(Adapter $adapter)
    {
        $this->table = new TableGateway(self::TABLE_NAME, $adapter);
    }
    public function fetchAll()
    {
        return $this->table->select();
    }
}
