<?php
namespace Lookup\Model;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserModelFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserModel($serviceLocator->get('Lookup\Model\Adapter'));
    }
}