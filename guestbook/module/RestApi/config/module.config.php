<?php
namespace RestApi;
use RestApi\Controller\{ApiController, Factory\ApiControllerFactory};
use RestApi\Service\{ApiService, Factory\ApiServiceFactory};
use Zend\Router\Http\Segment;
return [
    'router' => [
        'routes' => [
            'rest-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/:id]',
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                    ],
                    'constraints' => [
                        'id' => '[0-9]+',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            ApiController::class => ApiControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            ApiService::class => ApiServiceFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [ 'ViewJsonStrategy' ],
    ],
    'access-control-config' => [
        'resources' => [
            'rest-api-index'  => 'RestApi\Controller\ApiController',
        ],
        'rights' => [
            'guest' => [
                'rest-api-index' => ['allow' => NULL],
            ],
        ],
    ],
];
