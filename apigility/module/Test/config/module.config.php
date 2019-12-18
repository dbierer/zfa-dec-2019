<?php
return [
    'router' => [
        'routes' => [
            'test.rest.guestbook' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/guestbook[/:guestbook_id]',
                    'defaults' => [
                        'controller' => 'Test\\V1\\Rest\\Guestbook\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'test.rest.guestbook',
        ],
    ],
    'zf-rest' => [
        'Test\\V1\\Rest\\Guestbook\\Controller' => [
            'listener' => 'Test\\V1\\Rest\\Guestbook\\GuestbookResource',
            'route_name' => 'test.rest.guestbook',
            'route_identifier_name' => 'guestbook_id',
            'collection_name' => 'guestbook',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
                4 => 'POST',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \Test\V1\Rest\Guestbook\GuestbookEntity::class,
            'collection_class' => \Test\V1\Rest\Guestbook\GuestbookCollection::class,
            'service_name' => 'guestbook',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'Test\\V1\\Rest\\Guestbook\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Test\\V1\\Rest\\Guestbook\\Controller' => [
                0 => 'application/vnd.test.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'Test\\V1\\Rest\\Guestbook\\Controller' => [
                0 => 'application/vnd.test.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \Test\V1\Rest\Guestbook\GuestbookEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'test.rest.guestbook',
                'route_identifier_name' => 'guestbook_id',
                'hydrator' => \Zend\Hydrator\ArraySerializable::class,
            ],
            \Test\V1\Rest\Guestbook\GuestbookCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'test.rest.guestbook',
                'route_identifier_name' => 'guestbook_id',
                'is_collection' => true,
            ],
        ],
    ],
    'zf-apigility' => [
        'db-connected' => [
            'Test\\V1\\Rest\\Guestbook\\GuestbookResource' => [
                'adapter_name' => 'guestbook_adapter',
                'table_name' => 'guestbook',
                'hydrator_name' => \Zend\Hydrator\ArraySerializable::class,
                'controller_service_name' => 'Test\\V1\\Rest\\Guestbook\\Controller',
                'entity_identifier_name' => 'id',
                'table_service' => 'Test\\V1\\Rest\\Guestbook\\GuestbookResource\\Table',
            ],
        ],
    ],
    'zf-content-validation' => [
        'Test\\V1\\Rest\\Guestbook\\Controller' => [
            'input_filter' => 'Test\\V1\\Rest\\Guestbook\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'Test\\V1\\Rest\\Guestbook\\Validator' => [
            0 => [
                'name' => 'name',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            1 => [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            2 => [
                'name' => 'website',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '255',
                        ],
                    ],
                ],
            ],
            3 => [
                'name' => 'message',
                'required' => true,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '65535',
                        ],
                    ],
                ],
            ],
            4 => [
                'name' => 'avatar',
                'required' => false,
                'filters' => [
                    0 => [
                        'name' => \Zend\Filter\StringTrim::class,
                    ],
                    1 => [
                        'name' => \Zend\Filter\StripTags::class,
                    ],
                ],
                'validators' => [
                    0 => [
                        'name' => \Zend\Validator\StringLength::class,
                        'options' => [
                            'min' => 1,
                            'max' => '254',
                        ],
                    ],
                ],
            ],
            5 => [
                'name' => 'dateSigned',
                'required' => false,
                'filters' => [],
                'validators' => [],
            ],
        ],
    ],
    'zf-mvc-auth' => [
        'authorization' => [
            'Test\\V1\\Rest\\Guestbook\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
