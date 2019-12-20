<?php
namespace Login\Security\Factory;

use Login\Security\AuthStorage;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class AuthStorageFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        return new AuthStorage($container->get('login-storage-dir'));
    }
}
