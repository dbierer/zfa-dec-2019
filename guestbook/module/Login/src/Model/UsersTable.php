<?php
namespace Login\Model;

use Application\Model\ {AbstractTable, AbstractModel};
use Login\Security\Password;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class UsersTable extends AbstractTable
{

    public static $tableName = 'users';
    public static $identityCol = 'email';
    public static $passwordCol = 'password';
    public function findByEmail($email)
    {
        return $this->tableGateway->select(['email' => $email])->current();
    }
    public function save(AbstractModel $user)
    {
        $user->setPassword(Password::createHash($user->getPassword()));
        return $this->tableGateway->insert($user->extract());
    }
}
