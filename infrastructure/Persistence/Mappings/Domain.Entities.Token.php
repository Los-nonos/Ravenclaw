<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Domain\Entities\User;

$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('tokens');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->createOneToOne('user', User::class)
    ->cascadePersist()
    ->build();

$builder->addField('hash',Type::STRING);

$builder->addField(
    'createdAt',
    Type::DATETIME, [
        'nullable' => false,
        'options' => [
            'default' => 'CURRENT_TIMESTAMP'
        ]
    ]);

$builder->addField(
    'updatedAt',
    Type::DATETIME,
    [
        'nullable' => false,
        'options' => [
            'default' => 'CURRENT_TIMESTAMP'
        ]
    ]
);
