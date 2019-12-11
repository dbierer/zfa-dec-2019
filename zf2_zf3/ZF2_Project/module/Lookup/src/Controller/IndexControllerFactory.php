<?php
namespace Lookup\Controller;

use Lookup\Model\UserModel;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllerManager)
    {
        $serviceLocator = $controllerManager->getServiceLocator();
        return new IndexController($serviceLocator->get(UserModel::class));
    }
}