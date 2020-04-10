<?php

return [

    'buses' => [

        'default' => [

            'commandbus' => 'League\Tactician\CommandBus',

            'middleware' => [
                // ...
            ],

            'commmands' => [
                /*User*/
                'CreateUser' => [
                    'command' => 'Application\Commands\User\CreateUserCommand',
                    'handler' => 'Application\Handlers\User\CreateUserHandler'
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
