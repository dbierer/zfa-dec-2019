<?php
namespace Application;

use Application\Event\AppEvent;
use Application\Event\Listener\ {ErrorLog, ErrorLogWithFilter};
use Application\Session\ {CustomStorage, CustomManager};

use Zend\Mvc\MvcEvent;
use Zend\EventManager\LazyListener;
use Zend\Session\ {SessionManager,Container,Storage\SessionStorage};
use Zend\Db\Adapter\Adapter;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $container = $e->getApplication()->getServiceManager();
        $em = $e->getApplication()->getEventManager();
        // activate session manager and set as default for all containers
        $em->attach(MvcEvent::EVENT_ROUTE, [$this, 'setDefaultSessionManager'], 99);
        // lazy listener
        $em->attach(
            AppEvent::EVENT_LOG,
            new LazyListener([
                'listener' => ErrorLog::class,
                'method' => 'logMessage'],
                $container),
            100);
    }

    public function setDefaultSessionManager(MvcEvent $e)
    {
        $manager = $e->getApplication()->getServiceManager()->get('application-session-manager');
        Container::setDefaultManager($manager);
        //$manager->start();
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'application-db-adapter' => function ($container) {
                    return new Adapter($container->get('local-db-Config'));
                },
                'application-session-container' => function ($container) {
                    return new Container(__NAMESPACE__);
                },
                'application-session-storage' => function ($container) {
                    return new SessionStorage();
                    //return new CustomStorage($container->get('application-db-adapter'));
                },
                'application-session-manager' => function ($container) {
                    $manager = new SessionManager();
                    $manager->setStorage($container->get('application-session-storage'));
                    return $manager;
                },
            ],
        ];
    }
}
