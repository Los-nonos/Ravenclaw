<?php

return [

    'buses' => [

        'default' => [

            'commandbus' => 'League\Tactician\CommandBus',

            'middleware' => [
                // ...
            ],

            'commands' => [
                /*User*/
                'CreateCustomerHandler' => [
                    'command' => 'Application\Commands\Customers\CreateCustomerCommand',
                    'handler' => 'Application\Handlers\Customers\CreateCustomerHandler'
                ],
                'EditUser' => [
                    'command' => 'Application\Commands\User\EditUserCommand',
                    'handler' => 'Application\Handlers\User\EditUserHandler'
                ],
                'GetUser' => [
                    'command' => 'Application\Commands\User\GetUserCommand',
                    'handler' => 'Application\Handlers\User\GetUserHandler'
                ],
            ],

        ],

    ],
];
