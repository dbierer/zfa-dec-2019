<?php

namespace Events;
use Zend\Router\Http\ {Literal, Segment};
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;
use Zend\ServiceManager\AbstractFactory\{ConfigAbstractFactory, ReflectionBasedAbstractFactory};
use Events\Controller\{
    IndexController,
    ConsoleControllerFactory,
};
use Events\TableModule\{
    Controller\Factory\AdminControllerFactory,
    Controller\Factory\SignupControllerFactory,
    Controller\AdminController,
    Controller\IndexController as TabIndexController,
    Controller\ServiceLocatorAwareInterface,
    Controller\ServiceLocatorTrait,
    Controller\SignupController,
    Controller\TableTrait,
    Model\AttendeeTable,
    Model\Base,
    Model\EventTable,
    Model\RegistrationTable
};

//use Zend\Mvc\I18n\Router\TranslatorAwareTreeRouteStack;
return [
    'navigation' => [
        'default' => [
            'events' => ['label' => 'Events', 'route' => 'events', 'resource' => 'menu-events']
        ]
    ],
    'router' => [
        //'router_class' => TranslatorAwareTreeRouteStack::class,
        'routes' => [
            'events' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/events',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index',
                    ],
                ],
                'may_terminate' => TRUE,
                'child_routes' => [
                    'table-module' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/table-module',
                            'defaults' => [
                                'controller' => TabIndexController::class,
                                'action' => 'index',
                            ],
                        ],
                        'may_terminate' => TRUE,
                        'child_routes' => [
                            'admin' => [
                                'type' => Segment::class,
                                'options' => [
                                    'route' => '/admin[/][:event]',
                                    'defaults' => [
                                        'controller' => AdminController::class,
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                            'signup' => [
                                'type' => Segment::class,
                                'options' => [
                                    // example of translatable route:
                                    //'route'    => '/{signup}[/][:event]',
                                    'route' => '/signup[/][:event]',
                                    'defaults' => [
                                        'controller' => SignupController::class,
                                        'action' => 'index',
                                    ],
                                    'constraints' => [
                                        'event' => '[0-9]+',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            EventTable::class => ReflectionBasedAbstractFactory::class,
            AttendeeTable::class => ReflectionBasedAbstractFactory::class,
            RegistrationTable::class => ReflectionBasedAbstractFactory::class,
        ],
        'services' => [
            'events-menu-config' => [
                'events-table-module' => [
                    'label' => 'Table Module',
                    'route' => 'events',
                    'resource' => 'menu-events-tm',
                    'pages' => [
                        ['label' => 'Sign Up Form',
                            'route' => 'events/table-module/signup', 'resource' => 'menu-events-tm-signup',
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/signup', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/signup', 'params' => ['event' => 2]],
                            ],
                        ],
                        ['label' => 'Admin Area',
                            'route' => 'events/table-module/admin', 'resource' => 'menu-events-tm-admin',
                            // do not need ACL "resource" for pages below this
                            'pages' => [
                                ['label' => 'Event A', 'route' => 'events/table-module/admin', 'params' => ['event' => 1]],
                                ['label' => 'Event B', 'route' => 'events/table-module/admin', 'params' => ['event' => 2]],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'abstract_factories' => [
            LazyControllerAbstractFactory::class,
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            TabIndexController::class => LazyControllerAbstractFactory::class,
            IndexController::class => InvokableFactory::class,
            AdminController::class => AdminControllerFactory::class,
            SignupController::class => SignupControllerFactory::class,
        ],
    ],
    // this is not used in this course, but illustrates the use of ConfigAbstractFactory
    /*
    ConfigAbstractFactory::class => [
            Doctrine\Controller\SignupController::class => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
            Doctrine\Controller\AdminController::class  => [
                Doctrine\Repository\EventRepo::class,
                Doctrine\Repository\AttendeeRepo::class,
                Doctrine\Repository\RegistrationRepo::class,
            ],
    ],
     */
    'view_manager' => [
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    'access-control-config' => [
        'resources' => [
            'events-index' => 'Events\Controller\IndexController',
            'events-tb-index' => 'Events\TableModule\Controller\IndexController',
            'events-tb-admin' => 'Events\TableModule\Controller\AdminController',
            'events-tb-sign' => 'Events\TableModule\Controller\SignupController',
            'menu-events' => 'menu-events',
            'menu-events-tm' => 'menu-events-tm',
            'menu-events-tm-signup' => 'menu-events-tm-signup',
            'menu-events-tm-admin' => 'menu-events-tm-admin',

        ],
        'rights' => [
            'guest' => [
                'events-index' => ['allow' => NULL],
                'events-tb-index' => ['allow' => NULL],
                'events-tb-sign' => ['allow' => NULL],
                'menu-events' => ['allow' => NULL],
                'menu-events-tm' => ['allow' => NULL],
                'menu-events-tm-signup' => ['allow' => NULL],
            ],
            'admin' => [
                'events-tb-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
                'menu-events-tm-admin' => ['allow' => NULL, 'assert' => 'access-control-datetime-assert'],
            ],
        ],
    ],
];
