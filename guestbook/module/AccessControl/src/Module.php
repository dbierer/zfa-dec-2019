<?php
namespace AccessControl;
use AccessControl\Listener\AclListenerAggregate;
class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                AclListenerAggregate::class => function ($container) {
                    $aggregate = new AclListenerAggregate();
                    $aggregate->setAcl($container->get('access-control-guestbook-acl'));
                    $aggregate->setAuthService($container->get('login-auth-service'));
                    return $aggregate;
                },
            ],
        ];
    }

}
