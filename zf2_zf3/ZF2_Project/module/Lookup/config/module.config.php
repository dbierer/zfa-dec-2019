<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Lookup;

use Zend\Db\Adapter\AdapterServiceFactory;
return array(
    'router' => array(
        'routes' => array(
            'lookup' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/lookup',
                    'defaults' => array(
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    // NOTE: database params defined in /config/autoload/local.php
    'service_manager' => array(
        'factories' => array(
            'Lookup\Model\Adapter' => AdapterServiceFactory::class,
            'Lookup\Model\UserModel' => Model\UserModelFactory::class,
        ),
    ),
    'controllers' => array(
        'factories' => array(
            Controller\IndexController::class => Controller\IndexControllerFactory::class
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
