<?php
namespace Guestbook\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Guestbook\Form\GuestbookForm as GuestbookForm;
use Guestbook\Mapper\GuestbookMapper;
use Guestbook\Controller\GuestbookController;

class GuestbookControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $controller = new GuestbookController();
        $controller->setForm($container->get(GuestbookForm::class));
        $controller->setMapper($container->get(GuestbookMapper::class));
        return $controller;
    }
}
