<?php
namespace TestZf2\Factory;

use TestZf2\Listener\SwapAutoload;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserModelDelegatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $em = $container->get('EventManager');
        // push ZF2 autoloader onto stack
        $em->trigger(SwapAutoload::EVENT_PUSH_ZF2_AUTOLOADER, $this);
        // get instance of ZF2 service manager
        $zf2sm = $container->get('zf2-service-manager');
        // use instance to create UserModel
        $userModel = $zf2sm->get('Lookup\Model\UserModel');
        // pop ZF2 autoloader off stack
        $em->trigger(SwapAutoload::EVENT_POP_ZF2_AUTOLOADER, $this);
        return $userModel;
    }
}
