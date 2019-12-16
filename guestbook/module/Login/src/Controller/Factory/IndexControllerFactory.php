<?php
namespace Login\Controller\Factory;

use Login\Controller\IndexController;
use Login\Form\Login as LoginForm;
use Login\Form\Register as RegForm;
use Login\Model\UsersTable;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;


class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new IndexController();
        $controller->setTable($container->get(UsersTable::class))
            ->setRegForm($container->get(RegForm::class))
            ->setLoginForm($container->get(LoginForm::class))
            ->setAuthAdapter($container->get('login-auth-adapter'))
            ->setAuthService($container->get('login-auth-service'))
            ->setSessionContainer($container->get('application-session-container'))
            ->setSessionManager($container->get('application-session-manager'));
        return $controller;
    }
}
