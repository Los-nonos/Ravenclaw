<?php

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use Domain\Entities\Admin;
use Domain\Entities\Customer;
use Persistence\Doctrine\CurrentTimestampBuilder;


$builder = new ClassMetadataBuilder($metadata);
$builder->setTable('users');
$builder->createField('id', Type::INTEGER)
    ->makePrimaryKey()
    ->generatedValue()
    ->build();

$builder->addField('name', Type::STRING);

$builder->addField('surname', Type::STRING);

$builder->addField('email', Type::STRING);

$builder->addField('password', Type::STRING);

$builder->addField('isActive', Type::BOOLEAN);

$builder->createOneToOne('customer_id', Customer::class)
    ->cascadePersist()
    ->build();

$builder->createOneToOne('admin_id', Admin::class)
    ->cascadePersist()
    ->build();
