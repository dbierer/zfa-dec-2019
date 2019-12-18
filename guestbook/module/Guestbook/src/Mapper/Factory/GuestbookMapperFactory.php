<?php
namespace Guestbook\Mapper\Factory;

use Guestbook\Mapper\GuestbookMapper;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class GuestbookMapperFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $adapter = $container->get('guestbook-db-adapter');
        return new GuestbookMapper($adapter);
    }
}
