<?php
namespace Cache;

use Zend\Mvc\MvcEvent;
//*** CACHE LAB: add the appropriate "use" statements

class Module
{
    public function getServiceConfig()
    {
        return [
            'services' => [
				// override in /Config/autoload/cache.local.php
                'cache-Config' => [
                    'adapter' => [
						//*** CACHE LAB: complete the configuration for a filesystem cache adapter
						//*** CACHE LAB: make sure this directory exists and the PHP user can read/write
                    ],
                    'plugins' => [
                        'exception_handler' => ['throw_exceptions' => FALSE],
                    ],
                ],
            ],
            'factories' => [
                'cache-adapter' => function ($container) {
					//*** CACHE LAB: what to return?
                },
            ],
        ];
    }
}
