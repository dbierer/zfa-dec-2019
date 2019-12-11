<?php
namespace TestZf2\Factory;

use TestZf2\Listener\SwapAutoload;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Returns instance of ZF2 ServiceManager
 */
class Zf2ServiceManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        // get instance of ZF2 service manager
        $config    = $container->get('Config');
        $path      = $config['ZF2_Project']['path'];
        $zf2Config = include $path . '/config/application.config.php';
        $smConfig  = isset($zf2Config['service_manager']) ? $zf2Config['service_manager'] : array();
        $serviceManager = new \Zend\ServiceManager\ServiceManager(new \Zend\Mvc\Service\ServiceManagerConfig($smConfig));
        $serviceManager->setService('ApplicationConfig', $zf2Config);
        $serviceManager->get('ModuleManager')->loadModules();
        return $serviceManager;
    }
}
