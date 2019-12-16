<?php
return [
	// NOTE: this is provided because the ReflectionBasedAbstractFactory looks for high level factories
	//       such as the AdapterServiceFactory, which in turn looks for the "db" key in the "Config" service
	'db' => [
		'driver' => 'pdo_mysql',
		'dsn' => 'mysql:host=localhost;dbname=zfcourse',
		'username' => 'vagrant',
		'password' => 'vagrant',
		'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
	],
    'service_manager' => [
        'services' => [
            'local-db-Config' => [
                'driver' => 'pdo_mysql',
                'dsn' => 'mysql:host=localhost;dbname=zfcourse',
                'username' => 'vagrant',
                'password' => 'vagrant',
                'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
            ],
        ],
    ],
];
