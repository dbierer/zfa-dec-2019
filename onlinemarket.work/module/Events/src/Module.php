<?php
namespace Events;

use Events\Entity\ {Event, Registration, Attendee};
use Zend\Mvc\MvcEvent;
use Zend\EventManager\ {EventManager, SharedEventManager};
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Db\Adapter\Adapter;
use Zend\Filter;
use Zend\Form\Annotation\AnnotationBuilder;
//*** NAVIGATION LAB: add "use" statement for the ConstructedNavigationFactory
use Zend\Navigation\Service\ConstructedNavigationFactory;

class Module
{
	const MAX_NAMES_PER_TICKET = 6;
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\IndexController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setAcl($container->get('access-control-market-acl'));
                    $controller->setAuthService($container->get('login-auth-service'));
                    return $controller;
                },
                Controller\AdminController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventModel::class));
                    $controller->setRegTable($container->get(Model\RegistrationModel::class));
                    return $controller;
                },
                Controller\AjaxController::class  => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setRegTable($container->get(Model\RegistrationModel::class));
                    $controller->setAttendeeTable($container->get(Model\AttendeeModel::class));
                    return $controller;
                },
                Controller\SignupController::class => function ($container, $requestedName) {
                    $controller = new $requestedName();
                    $controller->setEventTable($container->get(Model\EventModel::class));
                    $controller->setRegTable($container->get(Model\RegistrationModel::class));
                    $controller->setAttendeeTable($container->get(Model\AttendeeModel::class));
                    $controller->setFilter($container->get('events-reg-data-filter'));
                    $controller->setRegForm($container->get('events-reg-form'));
                    return $controller;
                },
            ],
        ];
    }
    public function getServiceConfig()
    {
        return [
            'aliases' => [
                'events-db-adapter' => 'model-primary-adapter',
            ],
            'factories' => [
                'events-reg-data-filter' => function ($container) {
                    $filter = new Filter\FilterChain();
                    $filter->attach(new Filter\StringTrim())
                           ->attach(new Filter\StripTags());
                    return $filter;
                },
                //*** Lab: Forms and Fieldsets: use the AnnotationBUilder to produce a form
                'events-reg-form' => function ($container) {
					$form = ???;
					return $form;
				},
                //*** Lab: Forms and Fieldsets: use the AnnotationBUilder to produce a form
                'events-attendee-form' => function ($container) {
					$form = ???;
					return $form;
				},
                'events-service-container' => function ($container) {
                    return $container;
                },
                //*** ABSTRACT FACTORIES LAB: define a single abstract factory to build these table classes
                Model\EventModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                                //*** LAB: Lab: Object Hydration and Database Operations:
                                                //***      need to add an entity instance to the constructor
                                              $container);
                },
                Model\RegistrationModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                                //*** LAB: Lab: Object Hydration and Database Operations:
                                                //***      need to add an entity instance to the constructor
                                              $container);
                },
                Model\AttendeeModel::class => function ($container, $requestedName) {
                    return new $requestedName($container->get('events-db-adapter'),
                                                //*** LAB: Lab: Object Hydration and Database Operations:
                                                //***      need to add an entity instance to the constructor
                                              $container);
                },
				'events-navigation' => function ($container) {
	                $factory = new ConstructedNavigationFactory($container->get('events-nav-Config'));
                    return $factory->createService($container);
				},
            ],
        ];
    }
}

