<?php
namespace Guestbook\Form\Factory;

use Guestbook\Form\GuestbookAvatar;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Guestbook\Form\GuestbookForm as GuestbookForm;

class GuestbookFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $form = new GuestbookForm();
        $config = $container->get('guestbook-avatar-config');
        $form->setConfig($config);
        $form->addElements();
        $form->addInputFilter();
        return $form;
    }
}
