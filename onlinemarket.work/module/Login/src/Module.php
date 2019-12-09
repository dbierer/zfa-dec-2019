<?php
namespace Login;

use Zend\Mvc\MvcEvent;
use Zend\Db\Adapter\Adapter;
use Login\Model\UsersTable;
use Login\Auth\CustomStorage;
use Login\Security\Password;
use Zend\Crypt\Password\Bcrypt;

//*** AUTHENTICATION LAB: add required "use" statements


class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'services' => [
				//*** PASSWORD LAB: modify this to use "verify()" from the Password class
                'login-auth-callback' => function ($hash, $password) {
                    return '???';
                },
            ],
            'factories' => [
                'login-db-adapter' => function ($container) {
                    return new Adapter($container->get('model-primary-adapter-Config'));
                },
				//*** AUTHENTICATION LAB: define an authentication adapter
                'login-auth-adapter' => function ($container) {
					//*** AUTHENTICATION LAB: return a CallbackCheckAdapter instance with these arguments: auth adapter, tablename, identity col, password col and callback
                    return new CallbackCheckAdapter('???');
                },
				//*** AUTHENTICATION LAB: define authentication service storage
				'login-auth-storage' => function ($container) {
					return new CustomStorage($container->get('login-storage-file'));
				},
                'login-auth-service' => function ($container) {
					//*** AUTHENTICATION LAB: need storage and auth adapter as arguments
                    return new AuthenticationService('???');
                },
            ],
        ];
    }
}
