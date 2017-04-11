<?php
return [
    'doctrine' => [
        'orm' => [
            'auto_generate_proxy_classes' => false,
            'proxy_dir'                   => 'data/cache/EntityProxy',
            'proxy_namespace'             => 'EntityProxy',
            'underscore_naming_strategy'  => true,
        ],
        'connection' => [
            // default connection
            'orm_default' => [
                'driver'   => 'sqLite',
                'dbname'   => 'demoDb',
                'user'     => 'demoUser',
                'password' => 'demoPass',
                'host'     => 'db_e_ramal',
                'charset'  => 'UTF8',
            ],
        ],
        'annotation' => [
            'metadata' => [
                'src/App/Entity'
            ],
        ],
    ],
];